<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\EventModel;
use App\Models\LocationModel;
use App\Models\EventRequestModel;
use \stdClass;

class Participant extends BaseController
{
    public function __construct()
    {
      $this->db = \Config\Database::connect();
    }

    public function index()
    {
      if (!isset($_SESSION['id'])) {
        return redirect()->to(base_url('login'));
      }
      
      return view('participant/includes/header')
            .view('participant/includes/sidebar')
            .view('participant/includes/topnavigation')
            .view('participant/home')
            .view('participant/includes/footer');
    }

    public function events()
    {
      if (!isset($_SESSION['id'])) {
        return redirect()->to(base_url('login'));
      }
      
      $events = $this->db->table('events')
                ->select('events.*,event_requests.user_id, event_requests.event_id, event_requests.status')
                ->join('event_requests', 'events.id = event_requests.event_id AND event_requests.user_id = ' . $_SESSION['id'], 'left')
                // ->where('event_requests.user_id', $_SESSION['id'])
                ->orderBy('events.id', 'ASC')
                ->get()->getResult();
      $data = [ 'events' => $events ];
      return view('participant/includes/header')
            .view('participant/includes/sidebar')
            .view('participant/includes/topnavigation')
            .view('participant/events', $data)
            .view('participant/includes/footer');
    }

    public function event_page()
    {

      if (!isset($_SESSION['id'])) {
        return redirect()->to(base_url('login'));
      }

      if (isset($_GET['id'])) {
        $id = clean_input($_GET['id']);
        $event = $this->db->table('events')
                ->select('*')
                ->where('id', $id)
                ->get()->getRow();

        if ($event == null) return redirect()->to(base_url('participant/events'));

        // GET CURRENT RACE IF EXIST
        $current_event = $this->db->table('event_details')
                                  ->select('*')
                                  ->where(['user_id' => $_SESSION['id'], 'event_id' => $id])
                                  ->get()->getRow();

        if ($current_event != null) {
          $date1 = date_create($current_event->start);
          $date2 = date_create(date('Y-m-d H:i:s'));

          $diff = date_diff($date2, $date1);

          if ($diff->h > 0) {
            $event->hours = $event->hours - $diff->h;
          }
          if ($diff->m > 0) {
            $event->minutes = $event->minutes - $diff->m;
          }
        }

        $locations = $this->db->table('locations')
                              ->select('*')
                              ->where('event_id', $id)
                              ->get()->getResult();
        

        $data = [
          'event' => $event,
          'current_event' => $current_event,
          'locations' => $locations,
          'difference' => (isset($diff)) ? $diff : null
        ];
        
        return view('participant/includes/header')
              .view('participant/includes/sidebar')
              .view('participant/includes/topnavigation')
              .view('participant/event', $data)
              .view('participant/includes/footer');
      } else {
        return redirect()->to(base_url('participant/events'));
      }
    }

    public function event_start()
    {
      if (!isset($_SESSION['id'])) {
        return redirect()->to(base_url('login'));
      }

      if (isset($_POST['event_start'])) {
        $event_id = clean_input($_POST['event_id']);
        $user_id = $_SESSION['id'];

        $this->db->table('event_details')
        ->set([
          'event_id' => $event_id,
          'user_id' => $user_id
        ])
        ->insert();

        echo json_encode(['event_start' => true]);
      }
    }

    public function event_request()
    {
      if (!isset($_SESSION['id'])) {
        return redirect()->to(base_url('login'));
      }
      
      $event_id = clean_input($_GET['id']);
      $user_id = $_SESSION['id'];
      // CHECK IF EVENT EXIST
      $event_model = new EventModel();
      $event = $event_model->where(['id' => $event_id])->first();
      if ($event !== NULL) {
        $request_model = new EventRequestModel();
        $request_model->insert([
          'event_id' => $event_id,
          'user_id' => $user_id,
          'status' => 0
        ]);

        return redirect()->to(base_url('participant/events'))->with('success', 'Request sent successfully');
      }
    }

    public function add_event()
    {
      if (!isset($_SESSION['id'])) {
        return redirect()->to(base_url('login'));
      }
      
      return view('organizer/includes/header')
            .view('organizer/includes/sidebar')
            .view('organizer/includes/topnavigation')
            .view('organizer/add_event')
            .view('organizer/includes/footer');
    }

    public function save_event()
    {
      if (!isset($_SESSION['id'])) {
        return redirect()->to(base_url('login'));
      }
      
      $name = $this->request->getPost('name');
      $hours = $this->request->getPost('hours');
      $minutes = $this->request->getPost('minutes');
      $event = new EventModel();
      $event->insert(Array(
        'name' => $name,
        'hours' => $hours,
        'minutes' => $minutes,
        'created_by' => $this->session->get('id')
      ));

      return redirect()->to(base_url('organizer/events/add'))->with('success', 'Event added successfully');
    }

    public function delete_event()
    {
      if (!isset($_SESSION['id'])) {
        return redirect()->to(base_url('login'));
      }
      
      $id = $this->request->getGet('id');
      $event = new EventModel();
      $event->delete($id);

      return redirect()->to(base_url('organizer/events'));
    }

    public function edit_event()
    {
      if (!isset($_SESSION['id'])) {
        return redirect()->to(base_url('login'));
      }
      
      if ($this->request->getGet('id')) {
        $event_id = clean_input($this->request->getGet('id'));
        $event = new EventModel();
        $event = $event->where(['id' => $event_id])->first();
        $data = [ 'event' => $event ];
        
        if (!empty($event)) {
          $this->session->set('update_event_id', $event['id']);
          return view('organizer/includes/header')
                .view('organizer/includes/sidebar')
                .view('organizer/includes/topnavigation')
                .view('organizer/edit_event', $data)
                .view('organizer/includes/footer');
        }
      }
    }

    public function update_event()
    {
      if (!isset($_SESSION['id'])) {
        return redirect()->to(base_url('login'));
      }
      
      if ($this->session->get('update_event_id')) {
        $id = $this->session->get('update_event_id');
        $name = $this->request->getPost('name');
        $hours = $this->request->getPost('hours');
        $minutes = $this->request->getPost('minutes');
        $event_model = new EventModel();
        $event_model->update($id, Array(
          'name' => $name,
          'hours' => $hours,
          'minutes' => $minutes,
          'created_by' => $this->session->get('id')
        ));
        $this->session->remove('update_event_id');
        return redirect()->to(base_url('organizer/events/edit?id='.$id))->with('success', 'Event updated successfully');
      }
    }

    public function locations()
    {
      if (!isset($_SESSION['id'])) {
        return redirect()->to(base_url('login'));
      }
      
      if ($this->request->getGet('event_id')) {
        $selected_event = clean_input($this->request->getGet('event_id'));
        $event_model = new EventModel();
        
        $events = $event_model->find();

        $location_model = new LocationModel();
        $locations = $location_model->where(['event_id' => $selected_event])->find();

        $data = [ 'events' => $events, 'selected_event' => $selected_event, 'locations' => $locations ];

        if (!empty($events)) {
          return view('organizer/includes/header')
                  .view('organizer/includes/sidebar')
                  .view('organizer/includes/topnavigation')
                  .view('organizer/locations', $data)
                  .view('organizer/includes/footer');
        }
      } else {
        $event_model = new EventModel();
        $events = $event_model->find();
        $data = [ 'events' => $events ];
        if (!empty($events)) {
          return view('organizer/includes/header')
                  .view('organizer/includes/sidebar')
                  .view('organizer/includes/topnavigation')
                  .view('organizer/locations', $data)
                  .view('organizer/includes/footer');
        }
      }
    }

    public function save_location()
    {
      if (!isset($_SESSION['id'])) {
        return redirect()->to(base_url('login'));
      }
      
      // echo FCPATH;exit;
      $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $_POST['latitude_longitude_image']));
      $img = $_POST['latitude_longitude_image']; // Your data 'data:image/png;base64,AAAFBfj42Pj4';
      $img = str_replace('data:image/png;base64,', '', $img);
      $img = str_replace(' ', '+', $img);
      $data = base64_decode($img);

      $barcode_image = time() . '-' .  generateRandomString(10) . '.png';

      file_put_contents(FCPATH . "barcode_images/$barcode_image", $data);
      $event_id = clean_input($_POST['event_id']);
      $location = clean_input($_POST['location']); 
      $latitude_longitude = clean_input($_POST['latitude_longitude']); 

      $location_model = new LocationModel();
      $location_model->insert(Array(
        'event_id' => $event_id,
        'location' => $location,
        'latitude_longitude' => $latitude_longitude,
        'barcode_image' => $barcode_image
      ));

      return redirect()->to('organizer/locations?event_id='.$event_id)->with('success', 'Location saved successfully');
    }

    public function delete_location()
    {
      if (!isset($_SESSION['id'])) {
        return redirect()->to(base_url('login'));
      }
      
      if ($this->request->getGet('id')) {
        $location_id = clean_input($this->request->getGet('id'));
        $event = clean_input($this->request->getGet('event'));

        $location_model = new LocationModel();
        $location_model->delete($location_id);
        return redirect()->to('organizer/locations?event_id='.$event)->with('success', 'Location deleted successfully');
      }
    }

    public function edit_location()
    {
      if (!isset($_SESSION['id'])) {
        return redirect()->to(base_url('login'));
      }
      
      if ($this->request->getGet('id'))
      {
        $selected_event = clean_input($this->request->getGet('event'));
        $location_id = clean_input($this->request->getGet('id'));
        $location_model = new LocationModel();
        $location = $location_model->where(['id' => $location_id])->first();

        if ($location != NULL) {
          $data = ['location' => $location, 'selected_event' => $selected_event];
          return view('organizer/includes/header')
                  .view('organizer/includes/sidebar')
                  .view('organizer/includes/topnavigation')
                  .view('organizer/edit_location', $data)
                  .view('organizer/includes/footer');
        } else {
          return redirect()->to('organizer/locations');
        }
      }
    }

    public function update_location()
    {
      if (!isset($_SESSION['id'])) {
        return redirect()->to(base_url('login'));
      }
      
      if ($this->request->getPost('location_id')) {
        // FIRST SAVE THE BARCODE
        $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $_POST['latitude_longitude_image']));
        $img = $_POST['latitude_longitude_image']; // Your data 'data:image/png;base64,AAAFBfj42Pj4';
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);

        // NOW UPDATE THE DATA
        $barcode_image = time() . '-' .  generateRandomString(10) . '.png';

        file_put_contents(FCPATH . "barcode_images/$barcode_image", $data);

        $location_id = clean_input($_POST['location_id']);
        $event_id = clean_input($_POST['event_id']);
        $location = clean_input($_POST['location']); 
        $latitude_longitude = clean_input($_POST['latitude_longitude']); 

        $location_model = new LocationModel();
        $location_model->update(['id' => $location_id], Array(
          'location' => $location,
          'latitude_longitude' => $latitude_longitude,
          'barcode_image' => $barcode_image
        ));

        return redirect()->to('organizer/locations?event_id='.$event_id)->with('success', 'Location updated successfully');
      }
    }
      
}