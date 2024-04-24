<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\EventModel;
use App\Models\LocationModel;
use App\Models\EventRequestModel;
use \stdClass;

// require __DIR__ . "/vendor/autoload.php";

class User extends BaseController
{
    public function __construct()
    {
      $this->db = \Config\Database::connect();
    }


    public function view_race_result()
    {
      return view('race_result');
    }

    public function events()
    {
      if (!isset($_SESSION['id'])) {
        return redirect()->to(base_url('login'));
      }

      // $events = $this->db->table('events')
      //           ->select('events.*, event_requests.user_id, event_requests.event_id, event_requests.status')
      //           ->join('event_requests', 'events.id = event_requests.event_id AND event_requests.user_id = ' . $_SESSION['id'], 'left')
      //           // ->where('event_requests.user_id', $_SESSION['id'])
      //           ->where('events.type', 'orientation')
      //           ->orderBy('events.date', 'DESC')
      //           ->get()->getResult();
      
      // $data = [ 'events' => $events ];

      $events = $this->db->table('races')
                        ->select('races.*, event_requests.user_id, event_requests.event_id, event_requests.status')
                        ->join('event_requests', 'races.id = event_requests.event_id AND event_requests.user_id = ' . $_SESSION['id'], 'left')
                        ->orderBy('races.date', 'DESC')
                        ->get()->getResult();
      $data = [ 'events' => $events ];

      return  view('user/includes/header')
              .view('user/includes/navigation')
              .view('user/home', $data)
              .view('user/includes/footer');
    }

    public function event_request()
    {
      if (!isset($_SESSION['id'])) {
        return redirect()->to(base_url('login'));
      }
      
      $race_id = clean_input($_GET['id']);
      $user_id = $_SESSION['id'];
      // CHECK IF EVENT EXIST
      $query = $this->db->table('races')->where('id', $race_id)->get();
      // $event = $event_model->where(['id' => $event_id])->first();
      if ($query->getNumRows() > 0) {
        $request_model = new EventRequestModel();
        $request_model->insert([
          'event_id' => $race_id,
          'user_id' => $user_id,
          'status' => 0
        ]);

        return redirect()->to(base_url('user/events'))->with('success', 'Request sent successfully');
      }
    }

    public function event_page()
    {
      if (!isset($_SESSION['id'])) {
        return redirect()->to(base_url('login'));
      }

      $request = service('request');
      if ($request->getMethod() === 'post') {
        $image = $this->request->getFile('location_image');

        if ($image && $image->isValid()) {
            $event_id = $_GET['id'];
            $location_id = $_POST['location_id'];

            // GET POINTS OF LOCATION
            $location = $this->db->table('locations')->where('id', $location_id)->get()->getRow();
            if ($location == NULL) {
              return redirect()->to(base_url('events/view?id='.$event_id));
            }

            // IF USER HAS ALREAD REACHED LOCATION RETURN
            $location_reached = $this->db->table('locations_reached')
                                ->where(['user_id' => $_SESSION['id'], 'location_id' => $location_id])->get()->getRow();
            if ($location_reached != NULL) return redirect()->to(base_url('events/view?id='.$event_id))->with('location_error', "'$location->location' reached already!"); 

            
            
            $newName = $image->getRandomName();
            $image->move(ROOTPATH . 'public/location_images', $newName);
            $this->db->table('locations_reached')->insert(Array(
              'event_id' => $event_id,
              'user_id' => $_SESSION['id'],
              'location_id' => $location_id,
              'points' => $location->points,
              'image' => $newName,
              'date' => date_format(date_create(),"Y-m-d H:i:s")
            ));

            return redirect()->to(base_url('events/view?id='.$event_id))->with('location_msg', "'$location->location' reached successfully");
        }
      } else {
        $event_id = clean_input($_GET['id']);
        $event = $this->db->table('events')
                  ->where(['id' => $event_id ])
                  ->get()->getRow();
        
        // CHECK IF EVENT EXIST
        if ($event == null) return redirect()->to(base_url('/'))->with('error', 'Event doest not exist!');
        // CHECK IF USER ALLOWED TO PARTICIPATE IN EVENT
        // CHECK IN EVENT REQUESTS TABLE
        $event_request = $this->db->table('event_requests')
                                  ->where(['event_id' => $event_id, 'user_id' => $_SESSION['id']])
                                  ->get()->getRow();

        if ($event_request == null) return redirect()->to(base_url('/'))->with('error', 'You are not allowed for the event!');
        if ($event_request->status == 0) return redirect()->to(base_url('/'))->with('error', 'You are not allowed for the event!');

        // ALL LOCATIONS RELATED TO THE EVENT
        $all_locations = $this->db->table('locations')->where('event_id', $event_id)->select('*')->get()->getResult();
        // ALL LOCATIONS REACHED BY THE USER
        $locations_reached = $this->db->table('locations')
                              ->select('locations.*, locations_reached.date, locations_reached.status, locations_reached.revoke_reason')
                              ->join('locations_reached', 'locations.id = locations_reached.location_id AND locations_reached.user_id = '.$_SESSION['id'], 'left')
                              ->where(['locations.event_id' => $event_id])
                              ->get()->getResult();

        // $query = $this->db->table('locations_reached');
        // $query->select('locations.location, locations.points, locations_reached.date');
        // $query->join('locations', 'locations.id = locations_reached.location_id');
        // $query->where(['locations_reached.user_id' => $_SESSION['id'], 'locations_reached.event_id' => $event_id]);
        // $locations = $query->get()->getResult();

        $data = [
          'event' => $event, 
          'all_locations' => $all_locations,
          'locations_reached' => $locations_reached
        ];
        return  view('user/includes/header')
                .view('user/includes/navigation')
                .view('user/event', $data)
                .view('user/includes/footer');
      }
    }

    public function scan_qrcode()
    {
      if (!isset($_SESSION['id'])) {
        return redirect()->to(base_url('login'));
      }

      return  view('user/includes/header')
              .view('user/includes/navigation')
              .view('user/scan_qrcode')
              .view('user/includes/footer');
    }

    public function scan_qrcode_image()
    {
      if (!isset($_SESSION['id'])) {
        return redirect()->to(base_url('login'));
      }

      $file_name = $_FILES['file']['name'];
      $new_file_name = time() . '-' . $_FILES['file']['name'];
      // file_put_contents(FCPATH . "barcode_images/$new_file_name", $data);
      
      
      $target_file = FCPATH . "images_for_scan/$new_file_name";
      move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
      // echo json_encode(['file' => $target_file]);
      $qrcode = new QrReader($target_file);
      $text = $qrcode->text();
      echo json_encode(['text' => $text]);
    }

    public function verify_location()
    {
      $event_id = clean_input($_GET['event_id']);
      if (isset($_GET['location'])) {
        $location = clean_input($_GET['location']);
        $db_location = $this->db->table('locations')
                ->where(['location' => $location])
                ->get()->getRow();
      } else if (isset($_GET['location_id'])) {
        $location_id = clean_input($_GET['location_id']);
        $db_location = $this->db->table('locations')
                ->where(['id' => $location_id])
                ->get()->getRow();
      }
      

      if ($db_location == null) return redirect()->to(base_url('events/view?id=' . $event_id));

      $data = ['location' => $db_location];

      return  view('user/includes/header')
              .view('user/includes/navigation')
            .view('user/verify_location', $data)
              .view('user/includes/footer');
    }

    public function mark_location()
    {
      if (!isset($_SESSION['id'])) {
        return redirect()->to(base_url('login'));
      }

      $event_id = clean_input($_GET['event_id']);
      $location_id = clean_input($_GET['location_id']);
      $user_id = $_SESSION['id'];

      // HOW MUCH POINTS TO ASSIGN FOR LOCATION REACHED
      $location_object = $this->db->table('locations')
                                  ->where('id', $location_id)
                                  ->get()->getRow();
      $location_points = $location_object !== null ? $location_object->points : null;

      $location = $this->db->table('locations_reached')
                           ->where([
                            'event_id' => $event_id,
                            'location_id' => $location_id,
                            'user_id' => $user_id
                           ])
                           ->get()->getRow();

      // IF USER HAS NOT REACHED LOCATION
      if ($location == NULL) {
        $this->db->table('locations_reached')
                 ->insert([
                  'user_id' => $user_id,
                  'event_id' => $event_id,
                  'location_id' => $location_id,
                  'date' => date_format(date_create(),"Y-m-d H:i:s"),
                  'points' => $location_points
                 ]);

        
        header('Content-Type: application/json');
        echo json_encode(['location_marked' => true]);
        exit;
      } else {
        header('Content-Type: application/json');
        echo json_encode(['location_already_marked' => true]);
        exit;
      }

    }

    public function live_location(){
      $latitude = clean_input($_POST['latitude']);
      $longitude = clean_input($_POST['longitude']);
      $user_id = $_SESSION['id'];
      $currentDateTime = date('Y-m-d H:i:s');

      $data = ['latitude' => $latitude, 'longitude' => $longitude, 'user_id' => $user_id, 'date' => $currentDateTime];

      $previous = $this->db->table('live_locations')->where('user_id', $user_id)->get()->getResult();
      if ($previous == null) {
        $this->db->table('live_locations')->insert($data);
      } else {
        $this->db->table('live_locations')->where('user_id', $user_id)->update([
          'latitude' => $latitude,
          'longitude' => $longitude,
          'date' => $currentDateTime
        ]);
      }

    }

    public function index()
    {
    //   return;
    //   // Get the current date and time in MySQL format
    // $currentDateTime = date('Y-m-d H:i:s');

    // // Prepare the query
    // $query = "
    //     SELECT er.*
    //     FROM event_requests er
    //     INNER JOIN events e ON er.event_id = e.id
    //     WHERE er.user_id = ?
    //     AND er.status = 1
    //     AND e.date <= ?
    //     AND ADDTIME(e.date, CONCAT(e.hours, ':', e.minutes)) >= ?
    // ";

    // // Execute the query
    // $result = $this->db->query($query, [$_SESSION['id'], $currentDateTime, $currentDateTime]);
    // echo '<pre>';
    // var_dump($result->getResult());
    // echo '</pre>';exit;
      $data = [];
      return view('user/includes/header')
              .view('user/includes/navigation')
              .view('user/index', $data)
              .view('user/includes/footer');
    }

    public function accepted_for_today_event()
    {
      $user_id = $_SESSION['id'];
      $today = date('Y-m-d'); // Replace with the desired date format

      $query = $this->db->table('event_requests');
      $query->select('event_requests.user_id, event_requests.event_id, events.*');
      $query->join('events', 'events.id = event_requests.event_id');
      $query->where('event_requests.user_id', $user_id);
      $query->like('events.date', $today, 'after');
      $query->where('event_requests.status', 1); // Additional condition
      $result = $query->get()->getResult();

      if ($result && $query->countAllResults() > 0) {
        header('Content-Type: application/json');
        echo json_encode(['accepted' => true]);
        exit;
      } else {
        header('Content-Type: application/json');
        echo json_encode(['message' => 'Either event request is not accepted or event is not today']);
        exit;
      }
    }

    public function turn_on_location()
    {
      return view('user/includes/header')
              .view('user/includes/navigation')
              .view('user/turn_on_location')
              .view('user/includes/footer');
    }

    public function profile()
    {
        $model = new UserModel();
        $data['user'] = $model->where(['id' => $this->session->get('id')])->select('name, surname, email, machine, size_of_wheel, have_winch')->first();
        return view('user/includes/header')
              .view('user/includes/navigation')
              .view('user/profile', $data)
              .view('user/includes/footer');
    }

    public function update_profile()
    {
        if ($this->request->is('post')) {
            $name = clean_input($this->request->getPost('name'));
            $surname = clean_input($this->request->getPost('surname'));
            $model = new UserModel();

            if ($name != '' && $surname != '') {
                $model->update($this->session->get('id'), [
                    'name' => $name,
                    'surname' => $surname
                ]);

                return redirect()->to(base_url('user/profile'))->with('success', 'Profile updated successfully');
            } else {
                return redirect()->to(base_url('user/profile'));
            }
        } else {
            return redirect()->to(base_url('user/profile'));
        }
    }

    public function update_password()
    {
        if ($this->request->is('post')) {
            $old_password = clean_input($this->request->getPost('old_password'));
            $new_password = clean_input($this->request->getPost('new_password'));
            $confirm_password = clean_input($this->request->getPost('confirm_password'));

            if ($old_password == '' || $new_password == '' || $confirm_password == '') {
                return redirect()->to(base_url("user/profile"));
            }

            $model = new UserModel();
            $user = $model->where(['id' => $this->session->get('id')])->first();

            if (password_verify($old_password, $user['password'])) {
                $model->update($this->session->get('id'), [
                    'password' => password_hash($new_password, PASSWORD_DEFAULT)
                ]);

                return redirect()->to(base_url('user/profile'))->with('success', 'Password updated successfully');
            } else {
                return redirect()->to(base_url('user/profile'))->with('error', 'Incorrect old password');
            }
        } else {
            return redirect()->to(base_url('user/profile'));
        }
    }

    public function update_machine()
    {
      $machine = clean_input($_POST['machine']);
      $size_of_wheel = clean_input($_POST['size_of_wheel']);
      $have_winch = (isset($_POST['have_winch'])) ? $_POST['have_winch']: '';
      $have_winch = ($have_winch == 'yes') ? 1 : 0;
      
      if ($machine == '' || $size_of_wheel == '') {
        return redirect()->to(base_url("user/profile"));
      }
      
      $model = new UserModel();
      $model->update($this->session->get('id'), [
        'machine' => $machine,
        'size_of_wheel' => $size_of_wheel,
        'have_winch' => $have_winch
      ]);

      return redirect()->to(base_url('user/profile'))->with('success', 'Machine information updated successfully');
    }

    // LOGGEDIN USER CAN UPDATE EMAIL ON PROFILE SETTING PAGE 
    public function update_email()
    {
        if ($this->request->is('post') && $this->session->has('id'))
        {
            $email = clean_input($this->request->getPost('email'));
            $model = new UserModel();
            $user = $model->where(['id' => $this->session->get('id')])->first();
            $code = generateRandomString(8);

            if (!empty($user) && $user['email'] != $email) {
                $model->update($this->session->get('id'), [
                    'temp_email' => $email,
                    'email_confirmation_code' => $code
                ]);

                $confirm_email_link = base_url('user/save_new_email?code='.$code);

                $email_template = '
                <!doctype html>
                <html>
                  <head>
                    <meta name="viewport" content="width=device-width">
                    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                    <title>Simple Transactional Email</title>
                    
                  </head>
                  <body class="" style="background-color: #f6f6f6;font-family: sans-serif;-webkit-font-smoothing: antialiased;font-size: 14px;line-height: 1.4;margin: 0;padding: 0;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                    <table border="0" cellpadding="0" cellspacing="0" class="body" style="border-collapse: separate;mso-table-lspace: 0pt;mso-table-rspace: 0pt;width: 100%;background-color: #f6f6f6;">
                      <tr>
                        <td style="font-family: sans-serif;font-size: 16px !important;vertical-align: top;">&nbsp;</td>
                        <td class="container" style="font-family: sans-serif;font-size: 16px !important;vertical-align: top;display: block;max-width: 580px;padding: 0 !important;width: 100% !important;margin: 0 auto !important;">
                          <div class="content" style="box-sizing: border-box;display: block;margin: 0 auto;max-width: 580px;padding: 0 !important;">
                            <span class="preheader" style="color: transparent;display: none;height: 0;max-height: 0;max-width: 0;opacity: 0;overflow: hidden;mso-hide: all;visibility: hidden;width: 0;font-size: 16px !important;">Subscribe to Coloured.com.ng mailing list</span>
                            <table class="main" style="border-collapse: separate;mso-table-lspace: 0pt;mso-table-rspace: 0pt;width: 100%;background: #fff;border-radius: 0 !important;border-left-width: 0 !important;border-right-width: 0 !important;">
                
                              
                              <tr>
                                <td class="wrapper" style="font-family: sans-serif;font-size: 16px !important;vertical-align: top;box-sizing: border-box;padding: 10px !important;">
                                  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate;mso-table-lspace: 0pt;mso-table-rspace: 0pt;width: 100%;">
                                    <tr>
                                      <td style="font-family: sans-serif;font-size: 16px !important;vertical-align: top;">
                                        <h1 style="color: #000000;font-family: sans-serif;font-weight: 300;line-height: 1.4;margin: 0;margin-bottom: 30px;font-size: 35px;text-align: center;text-transform: capitalize;">Confirm your email</h1>
                                        <h2 style="color: #000000;font-family: sans-serif;font-weight: 400;line-height: 1.4;margin: 0;margin-bottom: 30px;">You are just one step away</h2>
                                        <table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary" style="border-collapse: separate;mso-table-lspace: 0pt;mso-table-rspace: 0pt;width: 100%;box-sizing: border-box;">
                                          <tbody>
                                            <tr>
                                              <td align="left" style="font-family: sans-serif;font-size: 16px !important;vertical-align: top;padding-bottom: 15px;">
                                                <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate;mso-table-lspace: 0pt;mso-table-rspace: 0pt;width: 100% !important;">
                                                  <tbody>
                                                    <tr>
                                                      <td style="font-family: sans-serif;font-size: 16px !important;vertical-align: top;background-color: #3498db;border-radius: 5px;text-align: center;"> <a href="'.$confirm_email_link.'" target="_blank" style="color: #ffffff;text-decoration: none;background-color: #3498db;border: solid 1px #3498db;border-radius: 5px;box-sizing: border-box;cursor: pointer;display: inline-block;font-size: 16px !important;font-weight: bold;margin: 0;padding: 12px 25px;text-transform: capitalize;border-color: #3498db;width: 100% !important;">confirm email</a> </td>
                                                    </tr>
                                                  </tbody>
                                                </table>
                                              </td>
                                            </tr>
                                          </tbody>
                                        </table>
                                        <p style="font-family: sans-serif;font-size: 16px !important;font-weight: normal;margin: 0;margin-bottom: 15px;">If you received this email by mistake, simply delete it. You won\t be subscribed if you don\t click the confirmation link above.</p>
                      
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>
                
                            
                            </table>
                
                            
                            
                            
                            
                          
                          </div>
                        </td>
                        <td style="font-family: sans-serif;font-size: 16px !important;vertical-align: top;">&nbsp;</td>
                      </tr>
                    </table>
                  </body>
                </html>';

                send_email($email, 'Confirm New Email', $email_template);

                return $this->response->setJSON([ "email_sent" => true ]);
            }
        }
    }

    public function save_new_email()
    {
        if ($this->request->getGet('code'))
        {
            $code = $this->request->getGet('code');
            $model = new UserModel();
            $user = $model->where(['email_confirmation_code' => $code])->first();

            if (!empty($user)) {
                $model->update($user['id'], [
                    'email' => $user['temp_email'],
                    'temp_email' => '',
                    'email_confirmation_code' => ''
                ]);

                return redirect()->to(base_url('user/profile'))->with('success', 'Email updated successfully');
            }
        } 
        else
        {
            return redirect()->to(base_url("user/profile"));
        }
    }

    public function logout()
    {
      session_unset();
      session_destroy();
      return redirect()->to(base_url('login'));
    }

}