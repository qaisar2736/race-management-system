<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\EventModel;
use App\Models\LocationModel;

class Organizer extends BaseController
{
    public function __construct()
    {
      $this->db = \Config\Database::connect();
      $this->organizer_page = base_url('organizer/events/track');
    }

    public function index()
    {
      if (!isset($_SESSION['id'])) {
        return redirect()->to(base_url('login'));
      } else if ($_SESSION['account_type'] == 'organizer') {
        return redirect()->to($this->organizer_page);
      }

      return $this->races();
      // return $this->events();
      // $event = new EventModel();
      // $events = $event->find();
      // $data = [ 'events' => $events ];
      // return view('organizer/includes/header')
      //       .view('organizer/includes/sidebar')
      //       .view('organizer/includes/topnavigation')
      //       .view('organizer/home', $data)
      //       .view('organizer/includes/footer');
    }

    public function categories()
    {
      if (!isset($_SESSION['id'])) {
        return redirect()->to(base_url('login'));
      } else if ($_SESSION['account_type'] == 'organizer') {
        return redirect()->to($this->organizer_page);
      }
      // $categories = $this->db->table('categories')
      //               ->select('*')   
      //               ->get()->getResult();
      $builder = $this->db->table('categories');
      $builder->select('categories.id, categories.name, COUNT(events.id) as event_count');
      $builder->join('events', 'categories.id = events.category', 'left');
      $builder->groupBy('categories.id');
      $categories = $builder->get()->getResult();
      $data = [ 'categories' => $categories ];
      return view('organizer/includes/header')
            .view('organizer/includes/sidebar')
            .view('organizer/includes/topnavigation')
            .view('organizer/categories', $data)
            .view('organizer/includes/footer');
    }

    public function get_categories()
    {
      $type = clean_input($_GET['type']);
      $categories = $this->db->table('categories')->where('type', $type)->get()->getResult();

      header('Content-Type: application/json; charset=utf-8');
      echo json_encode([ 'categories' => $categories ]);exit;
    }

    public function add_category()
    {
      $category = clean_input($_POST['category']);$type = clean_input($_POST['type']);
      $data = ['name' => $category,'type' => $type];

      $previous = $this->db->table('categories')->select('id')->where(['name'=>$category,'type'=>$type])->get()->getResult();
      if (count($previous) > 0) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([ 'category_already_exist' => true ]);exit;
      }

      $this->db->table('categories')->insert($data);

      $categories = $this->db->table('categories')->where('type', $type)->get()->getResult();
      $response = [ 'created' => true];
      $response[$type] = $categories;
      header('Content-Type: application/json; charset=utf-8');
      echo json_encode($response);exit;
    }

    public function update_category()
    {
      $category = clean_input($_POST['category']);
      $id = clean_input($_POST['id']);
      $this->db->table('categories')
               ->where(['id' => $id])
               ->update(['name' => $category]);

      header('Content-Type: application/json; charset=utf-8');
      echo json_encode([ 'success' => true ]);exit;       
    }

    public function delete_category()
    {
      $id = clean_input($_POST['id']);
      $this->db->table('categories')->delete([ 'id' => $id ]);

      header('Content-Type: application/json; charset=utf-8');
      echo json_encode([ 'success' => true ]);exit;
    }

    public function save_track_event()
    {
      $name = clean_input($_POST['name']);
      // $hours = clean_input($_POST['hours']);
      // $minutes = clean_input($_POST['minutes']);
      // $date = clean_input($_POST['date']);
      $category = clean_input($_POST['category']);
      $race = clean_input($_POST['race']);
      $type = 'track';

      $previous = $this->db->table('events')->where(['name' => $name, 'type' => $type])->get()->getResult();
      if (count($previous) > 0) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([ 'event_name_used' => true ]);exit;
      } else {
        $this->db->table('events')->insert(Array(
          'race' => $race,
          'name' => $name,
          // 'hours' => $hours,
          // 'minutes' => $minutes,
          // 'date' => date_format(date_create($date), "Y-m-d H:i:s"),
          'type' => $type,
          'created_by' => $_SESSION['id'],
          'category' => $category,
        ));

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([ 'event_saved' => true ]);exit;
      }
    }

    public function save_orientation_event()
    {
      $name = clean_input($_POST['name']);
      $hours = clean_input($_POST['hours']);
      $minutes = clean_input($_POST['minutes']);
      $date = clean_input($_POST['date']);
      $category = clean_input($_POST['category']);
      $type = 'orientation';
      $race = clean_input($_POST['race']);

      $previous = $this->db->table('events')->where(['name' => $name, 'type' => $type])->get()->getResult();
      if (count($previous) > 0) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([ 'event_name_used' => true ]);exit;
      } else {
        $this->db->table('events')->insert(Array(
          'race' => $race,
          'name' => $name,
          'hours' => $hours,
          'minutes' => $minutes,
          'date' => date_format(date_create($date), "Y-m-d H:i:s"),
          'type' => $type,
          'created_by' => $_SESSION['id'],
          'category' => $category,
        ));

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([ 'event_saved' => true ]);exit;
      }
    }

    public function get_all_orientation_events()
    {
      $race = clean_input($_GET['race']);
      $order_by = isset($_GET['order_by']) ? clean_input($_GET['order_by']) : '';
      $limit = isset($_GET['limit']) ? clean_input($_GET['limit']): '';
      // Build the SQL query as a string
      $sql = "SELECT e.name AS event_name, e.id AS event_id, e.hours, e.minutes, e.date, e.created_by, e.type,
      c.name AS category_name
      FROM events e
      JOIN categories c ON e.category = c.id
      WHERE e.type = 'orientation' AND e.race = $race";
      if ($order_by != '') {
        $sql .= ' ORDER BY ' . $order_by;
      }
      if ($limit != '') {
        $sql .= ' LIMIT ' . $limit;
      }
      //ORDER BY e.id DESC";

      // Use the query() method to execute the SQL query
      $results = $this->db->query($sql)->getResult();
      header('Content-Type: application/json; charset=utf-8');
      echo json_encode([ 'events' => $results ]);exit;
    }

    public function get_all_track_events()
    {
      $race_id = clean_input($_GET['race_id']);
      // Build the SQL query as a string
      $sql = "SELECT e.name AS event_name, e.id AS event_id, e.hours, e.minutes, e.date, e.created_by, e.type,
      c.name AS category_name, c.id as category_id
      FROM events e
      JOIN categories c ON e.category = c.id
      WHERE e.type = 'track' AND race = '$race_id'";

      // Use the query() method to execute the SQL query
      $results = $this->db->query($sql)->getResult();
      header('Content-Type: application/json; charset=utf-8');
      echo json_encode([ 'events' => $results ]);exit;
    }

    public function get_all_events()
    {
      $type = clean_input($_GET['type']);
      $sql = "SELECT * FROM events WHERE type = '$type' ORDER BY id DESC";
      $results = $this->db->query($sql)->getResult();
      header('Content-Type: application/json; charset=utf-8');
      echo json_encode([ 'events' => $results ]);exit;
    }

    public function add_classes_to_event() 
    {
      $event_id = clean_input($_POST['event_id']);
      $classes = clean_input($_POST['classes']);

      $this->db->table('events')->where(['id' => $event_id])->update(['classes'=> $classes]);

      header('Content-Type: application/json; charset=utf-8');
      echo json_encode([ 'class_added' => true ]);exit;
    }

    public function get_single_orientation_event()
    {
      $id = clean_input($_GET['event_id']);
      $event = $this->db->table('events')->where('id', $id)->get()->getRow();

      header('Content-Type: application/json; charset=utf-8');
      echo json_encode([ 'event' => $event ]);exit;
    }

    public function delete_one_event()
    {
      $event_id = $this->request->getGet('event_id');
      $builder = $this->db->table('events'); // get the Query Builder instance

      $builder->where('id', $event_id); // set the WHERE condition to match the ID
      $builder->delete(); // delete the item

      header('Content-Type: application/json; charset=utf-8');
      echo json_encode([ 'deleted' => true ]);exit;
    }

    public function races()
    {
      $races = $this->db->table('races')->select('*')->orderBy('id', 'DESC')
      ->limit(50)->get()->getResult();
      $data = ['races' => $races];
      return view('organizer/includes/header')
            .view('organizer/includes/sidebar')
            .view('organizer/includes/topnavigation')
            .view('organizer/races/list', $data)
            .view('organizer/includes/footer');
    }

    public function add_race()
    {
      if ($this->request->getMethod() === 'post') {
        $name = clean_input($_POST['name']);
        $row = $this->db->table('races')->where('name', $name)->get()->getRow();
        
        if ($row !== null) {
          return redirect()->to(base_url('organizer/races/add'))->with('error', 'Race with same name already exist!');
        } else {
          $this->db->table('races')->insert(Array('name' => $name));

          return redirect()->to(base_url('organizer/races/add'))->with('success', 'New race created successfully!');
        }
      }
      return view('organizer/includes/header')
            .view('organizer/includes/sidebar')
            .view('organizer/includes/topnavigation')
            .view('organizer/races/add_race')
            .view('organizer/includes/footer');
    }

    public function delete_race($id)
    {
      $id = clean_input($id);
      $this->db->table('races')->where('id', $id)->delete();
      return redirect()->to(base_url('organizer/races'))->with('success', 'Race deleted successfully!');
    }

    public function edit_race($id)
    {
      if ($this->request->getMethod() === 'post') {
        $id = clean_input($id);
        $name = clean_input($_POST['name']);
        
        $this->db->table('races')->where('id', $id)->update(['name' => $name]);
        return redirect()->to(base_url('organizer/races'))->with('success', 'Race updated successfully!');
      }

      $id = clean_input($id);
      $race = $this->db->table('races')->where('id', $id)->get()->getRow();
      $data = ['race' => $race];
      if ($race !== null) {
        return view('organizer/includes/header')
              .view('organizer/includes/sidebar')
              .view('organizer/includes/topnavigation')
              .view('organizer/races/edit_race', $data)
              .view('organizer/includes/footer');
      }
    }

    public function view_race($id)
    {
      if (!isset($_SESSION['id'])) {
        return redirect()->to(base_url('login'));
      } else if ($_SESSION['account_type'] == 'organizer') {
        return redirect()->to($this->organizer_page);
      }

      $race = $this->db->table('races')->where('id', $id)->get()->getRow();
      if ($race == null) {
        return redirect()->to(base_url('organizer/races'));
      }

      $orientation_events = $this->db->table('events')
                                        ->select('events.*, categories.name AS category_name')
                                        ->join('categories', 'categories.id = events.category', 'left')
                                        ->where(['events.type' => 'orientation', 'events.race' => $id])
                                        ->orderBy('id', 'DESC')
                                        ->limit(50)
                                        ->get()->getResult();

      $track_events = $this->db->table('events')
                                ->select('events.*, categories.name AS category_name')
                                ->join('categories', 'categories.id = events.category', 'left')
                                ->where(['events.type' => 'track', 'events.race' => $id])
                                ->orderBy('id', 'DESC')
                                ->limit(50)
                                ->get()->getResult();

      $categories = $this->db->table('categories')->get()->getResult();

      $data = [
        'race' => $race,
        'orientation_events' => $orientation_events,
        'track_events' => $track_events,
        'categories' => $categories
      ];
      return view('organizer/includes/header')
            .view('organizer/includes/sidebar')
            .view('organizer/includes/topnavigation')
            .view('organizer/races/race_events', $data)
            .view('organizer/includes/footer');
    }

    public function events($race_id = null)
    {
      if (!isset($_SESSION['id'])) {
        return redirect()->to(base_url('login'));
      } else if ($_SESSION['account_type'] == 'organizer') {
        return redirect()->to($this->organizer_page);
      }

      if ($race_id == null) return redirect()->to(base_url('organizer/races'));

      $race = $this->db->table('races')->where('id', $race_id)->get()->getRow();
      if ($race == null) return redirect()->to(base_url('organizer/races'));

      $event = new EventModel();
      $events = $event->find();

      // Get the current date
      $today = date('Y-m-d');

      // Build the query
      $query = $this->db->table('events')
          ->where('type', 'orientation')
          ->where('race', $race_id)
          ->like('date', $today)
          ->get();

      // Return the result
      $today_events = $query->getResult();

      // Extract the 'name' property values into a new array
      $names = array_column($today_events, 'name');

      // Create a comma-separated string using the extracted values
      $events_name = implode(',', $names);

      $data = [ 'events' => $events , 'events_name' => $events_name, 'race' => $race];

      return view('organizer/includes/header')
            // .view('organizer/includes/sidebar')
            // .view('organizer/includes/topnavigation')
            .view('organizer/events', $data)
            .view('organizer/includes/footer');
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
      $type = $this->request->getPost('type');
      $hours = $this->request->getPost('hours');
      $minutes = $this->request->getPost('minutes');
      $date = $this->request->getPost('date');
      $event_date_time = date_create($date);
      $event_date_time = date_format($event_date_time,"Y-m-d H:i:s");

      $event = new EventModel();
      $event->insert(Array(
        'name' => $name,
        'type' => $type,
        'hours' => $hours,
        'minutes' => $minutes,
        'date' => $date,
        'created_by' => $this->session->get('id')
      ));

      return redirect()->to(base_url('organizer/events'))->with('success', 'Event added successfully');
    }

    public function delete_event()
    {
      if (!isset($_SESSION['id'])) {
        return redirect()->to(base_url('login'));
      }
      
      $id = $this->request->getGet('id');
      $event = new EventModel();
      $event->delete($id);

      return redirect()->to(base_url('organizer/events'))->with('success', 'Event deleted successfully!');
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

      $event_id = clean_input($_POST['event_id']);
      $name = clean_input($_POST['name']);
      $hours = (isset($_POST['hours'])) ? clean_input($_POST['hours']) : '';
      $minutes = (isset($_POST['minutes'])) ? clean_input($_POST['minutes']) : '';
      $date = (isset($_POST['date'])) ? clean_input($_POST['date']) : '';
      $category = clean_input($_POST['category']);
      $classes = clean_input($_POST['classes']);

      // $previous = $this->db->query("SELECT * FROM events WHERE name = '$name' AND id != $event_id")->getResult();
      $previous = $this->db->table('events')
                            ->where('name', $name)
                            ->where('id != ', $event_id)
                            ->get()->getResult();
      if (count($previous) > 0) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['event_name_used' => true]);exit;
      } else {
        $this->db->table('events')->where(['id' => $event_id])->set(Array(
          'name' => $name,
          'hours' => $hours,
          'minutes' => $minutes,
          'date' => date_format(date_create($date),"Y-m-d H:i:s"),
          'category' => $category,
          'classes' => $classes
        ))->update();

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['event_updated' => true]);exit;
      }

      // if ($this->session->get('update_event_id')) {
      //   $id = $this->session->get('update_event_id');
      //   $name = $this->request->getPost('name');
      //   $type = $this->request->getPost('type');
      //   $hours = $this->request->getPost('hours');
      //   $minutes = $this->request->getPost('minutes');
      //   $event_model = new EventModel();
      //   $event_model->update($id, Array(
      //     'name' => $name,
      //     'type' => $type,
      //     'hours' => $hours,
      //     'minutes' => $minutes,
      //     // 'created_by' => $this->session->get('id')
      //   ));
      //   $this->session->remove('update_event_id');
      //   return redirect()->to(base_url('organizer/events'))->with('success', 'Event updated successfully');
      // }
    }

    public function get_available_classes()
    {
      $request_id = clean_input($_GET['request_id']);
      $request_details = $this->db->table('event_requests')->where(['id' => $request_id])->get()->getRow();
      $event_details = $this->db->table('events')->select('classes')->where(['id' => $request_details->event_id])->get()->getRow();
      
      $user = $this->db->table('users')->select('name,surname,machine,size_of_wheel,have_winch')->where(['id' => $request_details->user_id])->get()->getRow();

      header('Content-Type: application/json; charset=utf-8');
      echo json_encode(['classes' => $event_details->classes, 'user' => $user]);exit;
    }

    public function approve_request()
    {
      $request_id = clean_input($_POST['request_id']);
      $selected_class = clean_input($_POST['selected_class']);
      $this->db->table('event_requests')->where(['id' => $request_id])->set([
        'status' => 1,
        'class' => $selected_class
      ])->update();
      header('Content-Type: application/json; charset=utf-8');
      echo json_encode([ 'approved' => true ]);exit;
    }

    public function event_track($id = null) {
      if (!isset($_SESSION['id'])) {
        return redirect()->to(base_url('login'));
      }

      $users = $this->db->table('users')
                      ->select('users.id, users.name, users.surname')
                      ->where('account_type', 'participant')
                      ->get()->getResult();

      if ($id == null) {
        $tracks = $this->db->table('events')
                          ->select('*')
                          ->where('type', 'track')
                          ->get()->getResult();
      } else {
        $tracks = $this->db->table('events')
                          ->select('*')
                          ->where('type', 'track')
                          ->where('race', $id)
                          ->get()->getResult();
      }
      

      $races = $this->db->table('races')
                        ->select('*')
                        ->get()->getResult();
      
      $data = [ 'event_id' => $id, 'users' => $users, 'tracks' => $tracks, 'races' => $races ];

      return view('organizer/includes/header')
            .view('organizer/includes/sidebar', $data)
            .view('organizer/includes/topnavigation')
            .view('organizer/event_track', $data)
            .view('organizer/includes/footer');
    }

    /* TRACKS ARE CATEGORIZED UNDER CATEGORY SO WE SHOW ONLY TRACKS WITH SPECIFIED CATEGORY ID */
    public function category_track($event_id, $category_id) {
      if (!isset($_SESSION['id'])) {
        return redirect()->to(base_url('login'));
      }

      $category = $this->db->table('categories')->where('id', $category_id)->get()->getRow();

      $users = $this->db->table('users')
                      ->select('users.id, users.name, users.surname')
                      ->where('account_type', 'participant')
                      ->get()->getResult();

      $tracks = $this->db->table('events')
                          ->select('*')
                          ->where('type', 'track')
                          ->where('category', $category_id)
                          ->get()->getResult();
      
      $data = [ 'event_id' => $event_id, 'users' => $users, 'tracks' => $tracks, 'category' => $category ];

      return view('organizer/includes/header')
            .view('organizer/includes/sidebar')
            .view('organizer/includes/topnavigation')
            .view('organizer/event_track', $data)
            .view('organizer/includes/footer');
    }

    public function orentance_track($id) {
      if (!isset($_SESSION['id'])) {
        return redirect()->to(base_url('login'));
      }

      echo $id;
      exit;
    }

    // find user for event track
    public function find_user($event_id, $user_id, $track)
    {
      if (!isset($_SESSION['id'])) {
        return redirect()->to(base_url('login'));
      }

      $event_id = clean_input($event_id);
      $user_id = clean_input($user_id);
      $track = clean_input($track);
      $user = $this->db->table('users')
              ->where(['id' => $user_id])
              ->get()->getRow();

      $users = $users = $this->db->table('users')
      ->select('users.id, users.name, users.surname')
      ->get()->getResult();

      $track_info = $this->db->table('event_details')
                            ->where(Array(
                              'event_id' => $event_id,
                              'user_id' => $user_id,
                              'track' => $track
                            ))
                            ->get()->getRow();
      
      $data = Array(
        'user' => $user,
        'event_id' => $event_id,
        'track' => $track,
        'track_info' => $track_info,
        'users' => $users
      );

      if ($user == NULL) {
        return redirect()->to(base_url('organizer/events/track/'.$event_id))->with('error', 'User not found with this id');
      } else {
        return view('organizer/includes/header')
              .view('organizer/includes/sidebar')
              .view('organizer/includes/topnavigation')
              .view('organizer/event_track', $data)
              .view('organizer/includes/footer');
      }

      
    }

    public function start_all_event_tracks()
    {
      if (!isset($_SESSION['id'])) {
        return redirect()->to(base_url('login'));
      }

      $user_id = clean_input($_POST['user_id']);
      $event_id = clean_input($_POST['event_id']);
      // $track = clean_input($_POST['track']);
      $start_time = date_format(date_create(),"Y-m-d H:i:s");
      $this->db->table('event_details')
                ->insert(Array(
                  'user_id' => $user_id,
                  'event_id' => $event_id,
                  'start' => $start_time
                ));
      header('Content-Type: application/json; charset=utf-8');
      echo json_encode(['start' => $start_time]);exit;
    }

    public function end_all_event_tracks()
    {
      if (!isset($_SESSION['id'])) {
        return redirect()->to(base_url('login'));
      }

      $user_ids = ($_POST['user_ids']);
      $event_id = clean_input($_POST['event_id']);
      $track = clean_input($_POST['track']);
      $end_time = date_format(date_create(),"Y-m-d H:i:s");
      foreach ($user_ids as $user_id) {
        $this->db->table('event_details')
                ->where(Array(
                  'user_id' => $user_id,
                  'event_id' => $event_id,
                  'track' => $track,
                ))
                ->set(Array(
                  'end' => $end_time
                ))
                ->update();
      }
      header('Content-Type: application/json; charset=utf-8');
      echo json_encode(['end' => $end_time]);exit;
    }

    public function start_event_track()
    {
      if (!isset($_SESSION['id'])) {
        return redirect()->to(base_url('login'));
      }

      $user_id = clean_input($_POST['user_id']);
      $event_id = clean_input($_POST['event_id']);
      $track = clean_input($_POST['track']);
      $start_time = date_format(date_create(),"Y-m-d H:i:s");

      $this->db->table('event_details')
                ->insert(Array(
                  'user_id' => $user_id,
                  'event_id' => $event_id,
                  'track' => $track,
                  'start' => $start_time
                ));
      $inserted_id = $this->db->insertID();

      header('Content-Type: application/json; charset=utf-8');
      echo json_encode(['race_started' => true, 'start_time' => $start_time, 'inserted_id' => $inserted_id]);exit;
    }

    public function stop_event_track()
    {
      if (!isset($_SESSION['id'])) {
        return redirect()->to(base_url('login'));
      }

      $user_id = clean_input($_POST['user_id']);
      $event_id = clean_input($_POST['event_id']);
      $track = clean_input($_POST['track']);
      $end_time = date_format(date_create(),"Y-m-d H:i:s");

      $this->db->table('event_details')
                ->where(Array(
                  'user_id' => $user_id,
                  'event_id' => $event_id
                ))
                ->update(Array(
                  'end' => $end_time
                ));

      header('Content-Type: application/json; charset=utf-8');
      echo json_encode(['race_ended' => true, 'end_time' => $end_time]);exit;
    }

    public function delete_event_track()
    {
      $id = clean_input($_POST['id']);
      $this->db->table('event_details')->where('id', $id)->delete();
      header('Content-Type: application/json; charset=utf-8');
      echo json_encode(['deleted' => true]);exit;
    }

    public function update_event_track()
    {
      $id = clean_input($_POST['id']);
      $start = clean_input($_POST['start']);
      $end = clean_input($_POST['end']);
      $end = ($end == '') ? NULL : $end;
      $this->db->table('event_details')
      ->where('id', $id) // Replace $eventId with the actual event ID you want to update
      ->update([
          'start' => $start, // Replace $formattedStartDate with the formatted start date value
          'end' => $end, // Replace $formattedEndDate with the formatted end date value
      ]);
      header('Content-Type: application/json; charset=utf-8');
      echo json_encode(['updated' => true]);exit;
    }

    public function event_track_results()
    {
      if (!isset($_SESSION['id'])) {
        return redirect()->to(base_url('login'));
      }
      
      $results = $this->db->table('event_details')
                ->select('event_details.*, users.name, users.surname, users.email, users.mobile_number')
                ->join('users', 'users.id = event_details.user_id')
                ->get()->getResult();

      $data = ['results' => $results];

      return view('organizer/includes/header')
            .view('organizer/includes/sidebar')
            .view('organizer/includes/topnavigation')
            .view('organizer/event_track_results', $data)
            .view('organizer/includes/footer');
    }

    public function select_category_for_result()
    {
      $categories = $this->db->table('categories')
                              ->select('*')
                              ->where('type', 'track')
                              ->get()->getResult();

      $data = ['categories' => $categories];
      return view('organizer/includes/header')
            .view('organizer/includes/sidebar')
            .view('organizer/includes/topnavigation')
            .view('organizer/select_category_for_result', $data)
            .view('organizer/includes/footer');
    }

    public function category_results($category_id) {
      $category = $this->db->table('categories')->where('id', $category_id)->get()->getRow();
      // tracks for this category
      $tracks = $this->db->table('events')
                          ->distinct()
                          ->select('id, name')
                          ->where('category', $category_id)
                          ->get()
                          ->getResult(); // Use getResult() instead of getResultArray()
      $track_names_for_category_provided = array_map(function($object) {
      return $object->name;
      }, $tracks);
      
      $all_track_ids_for_given_category = array_map(function($object) {
        return $object->id;
      }, $tracks);

      $users = $this->db->table('users')
                        ->select('*')
                        ->where('account_type', 'participant')
                        ->get()
                        ->getResult();

      $event_details = $this->db->table('event_details')
                        ->select('*')
                        // ->where('category', $category_id)
                        // ->whereIn('id', $all_track_ids_for_given_category)
                        ->get()->getResult();
      

      $data = [
        'category' => $category,
        'users' => $users, 
        'event_details' => $event_details, 
        'tracks' => $track_names_for_category_provided,
      'all_track_ids_for_given_category' => $all_track_ids_for_given_category
    ];
      return view('organizer/includes/header')
            .view('organizer/includes/sidebar')
            .view('organizer/includes/topnavigation')
            .view('organizer/category_results', $data)
            .view('organizer/includes/footer');
    }

    public function tracks()
    {
      $user_id = clean_input($_GET['user_id']);
      $query = $this->db->table('event_details')
              ->select('event_details.*, CONCAT(users.name, " ", users.surname) as username, events.*')
              ->join('events', 'events.id = event_details.event_id')
              ->join('users', 'users.id = event_details.user_id')
              ->where('event_details.user_id', $user_id)
              ->get();
      $result = $query->getResult();
      $data = ['tracks' => $result];

      return view('organizer/includes/header')
                  .view('organizer/includes/sidebar')
                  .view('organizer/includes/topnavigation')
                  .view('organizer/tracks', $data)
                  .view('organizer/includes/footer');
    }

    public function map()
    {
      // Get the current date
      $today = date('Y-m-d');

      // Build the query
      $query = $this->db->table('events')
          ->where('type', 'orientation')
          ->like('date', $today)
          ->get();

      // Return the result
      $today_events = $query->getResult();

      // Extract the 'name' property values into a new array
      $names = array_column($today_events, 'name');

      // Create a comma-separated string using the extracted values
      $result = implode(',', $names);

      $data = ['events' => $result];
      return  view('organizer/includes/header')
                  .view('organizer/includes/sidebar')
                  .view('organizer/includes/topnavigation')
                  .view('organizer/map', $data)
                  .view('organizer/includes/footer');
    }

    public function get_live_locations()
    {
      $today = date('Y-m-d');
      $race_id = clean_input($_GET['race_id']);
      $query = $this->db->table('live_locations')
          ->select('live_locations.*, CONCAT(users.name, " ", users.surname) AS full_name')
          ->join('event_requests', 'event_requests.user_id = live_locations.user_id')
          ->join('events', 'events.id = event_requests.event_id')
          ->join('users', 'users.id = live_locations.user_id')
          ->like('events.date', $today)
          ->where('event_requests.status', 1)
          ->where('users.account_type', 'participant')
          ->where('events.race', $race_id)
          ->like('live_locations.date', $today)
          ->get();
          // $generatedQuery = $this->db->getLastQuery();
          // echo $generatedQuery;exit;
      $liveLocations = $query->getResult();
      header('Content-Type: application/json; charset=utf-8');
      echo json_encode(['liveLocations' => $liveLocations]);exit;
    }

    public function all_users()
    {
      if (!isset($_SESSION['id'])) {
        return redirect()->to(base_url('login'));
      }

      $all_users = $this->db->table('users')
                            ->get()->getResult();

      if (isset($_GET['jsonResponse'])) {

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['users' => $all_users]);exit;

      } else {
        $data = ['all_users' => $all_users];

        return view('organizer/includes/header')
              .view('organizer/includes/sidebar')
              .view('organizer/includes/topnavigation')
              .view('organizer/all_users', $data)
              .view('organizer/includes/footer');
      }
    }

    public function delete_user()
    {
      $id = clean_input($_POST['user_id']);

      // Get the Query Builder object
      $builder = $this->db->table('users');

      // Set the WHERE condition
      $builder->where('id', $id);

      // Delete the record
      $builder->delete();

      header('Content-Type: application/json; charset=utf-8');
      echo json_encode(['user_deleted' => true]);exit;        
    }

    public function add_user()
    {
      $name = clean_input($_POST['name']);
      $surname = clean_input($_POST['surname']);
      $userClass = clean_input($_POST['userClass']);
      $email = clean_input($_POST['email']);
      $mobile_number = clean_input($_POST['mobile_number']);
      $password = clean_input($_POST['password']);
      $account_type = clean_input($_POST['account_type']);
      $email_verified = clean_input($_POST['email_verified']);
      $machine = clean_input($_POST['machine']);
      $size_of_wheel = clean_input($_POST['size_of_wheel']);
      $hashed_password = password_hash($password, PASSWORD_DEFAULT);

      // FIRST CHECK IF EMAIL IS IN USE OR NOT
      $builder = $this->db->table('users'); // get a Query Builder instance for the 'users' table
      $builder->select('*'); // select all columns from the 'users' table
      $builder->where('email', $email); // add a WHERE clause to the query
      $query = $builder->get();

      if ($query->getNumRows() > 0) {
        header('Content-Type: application/json');
        echo json_encode(['email_used' => true]);exit;
      }

      $this->db->table('users')
                ->insert(Array(
                  'name' => $name,
                  'surname' => $surname,
                  'class' => $userClass,
                  'email' => $email,
                  'mobile_number' => $mobile_number,
                  'password' => $hashed_password,
                  'account_type' => $account_type,
                  'email_verified' => $email_verified,
                  'machine' => $machine,
                  'size_of_wheel' => $size_of_wheel
                ));

      $users = $this->db->table('users')
                        ->select('*')
                        ->get()->getResult();


      header('Content-Type: application/json');
      echo json_encode(['user_created' => true, 'users' => $users]);exit;
    }

    public function update_user()
    {
      $user_id = clean_input($_POST['user_id']);
      $name = clean_input($_POST['name']);
      $surname = clean_input($_POST['surname']);
      $class = clean_input($_POST['userClass']);
      $email = clean_input($_POST['email']);
      $mobile_number = clean_input($_POST['mobile_number']);
      $password = clean_input($_POST['password']);
      $account_type = clean_input($_POST['account_type']);
      $email_verified = clean_input($_POST['email_verified']);
      $machine = clean_input($_POST['machine']);
      $size_of_wheel = clean_input($_POST['size_of_wheel']);
      $hashed_password = password_hash($password, PASSWORD_DEFAULT);

      // FIRST CHECK IF EMAIL IS IN USE OR NOT
      $builder = $this->db->table('users'); // get a Query Builder instance for the 'users' table
      $builder->select('*'); // select all columns from the 'users' table
      $builder->where('email', $email); // add a WHERE clause to the query
      $builder->where('id != ', $user_id);
      $query = $builder->get();

      if ($query->getNumRows() > 0) {
        header('Content-Type: application/json');
        echo json_encode(['email_used' => true]);exit;
      }

      $data = Array(
        'name' => $name,
        'surname' => $surname,
        'class' => $class,
        'email' => $email,
        'mobile_number' => $mobile_number,
        'account_type' => $account_type,
        'email_verified' => $email_verified,
        'machine' => $machine,
        'size_of_wheel' => $size_of_wheel
      );

      if ($password != '') {
        $data['password'] = $hashed_password;
      }
    
      $this->db->table('users')
         ->where('id', $user_id)
         ->set($data)
         ->update();

      $users = $this->db->table('users')
                        ->select('*')
                        ->get()->getResult();


      header('Content-Type: application/json');
      echo json_encode(['user_updated' => true, 'users' => $users ]);exit;
    }

    public function event_requests()
    {
      if (!isset($_SESSION['id'])) {
        return redirect()->to(base_url('login'));
      }
      
      $event_requests = $this->db->table('event_requests')
                ->select('event_requests.*, races.name as event_name, users.name, users.surname, users.email as user_email')
                ->join('races', 'races.id = event_requests.event_id')
                ->join('users', 'users.id = event_requests.user_id')
                ->orderBy('event_requests.id', 'ASC')
                ->get()->getResult();
      $data = [
        'event_requests' => $event_requests
      ];
      return view('organizer/includes/header')
            .view('organizer/includes/sidebar')
            .view('organizer/includes/topnavigation')
            .view('organizer/event_requests', $data)
            .view('organizer/includes/footer');
    }

    public function approve_event_request()
    {
      if (!isset($_SESSION['id'])) {
        return redirect()->to(base_url('login'));
      }
      
      $id = clean_input($_GET['id']);
      $this->db->table('event_requests')
      ->set('status', 1)
      ->where('id', $id)
      ->update();

      return redirect()->to(base_url('organizer/event_requests'));
    }

    public function get_event_track_results()
    {
      // if (!isset($_SESSION['id'])) {
      //   return redirect()->to(base_url('login'));
      // } else if ($_SESSION['account_type'] != 'organizer') {
      //   return redirect()->to(base_url('login'));
      // }

      $query = $this->db->table('event_details');
      $query->select('event_details.id, event_details.event_id, event_details.user_id, event_details.track, event_details.start, event_details.end, users.name, users.surname, users.machine, users.size_of_wheel');
      $query->join('users', 'event_details.user_id = users.id');
      $query->where('event_details.start IS NOT NULL');
      $query->where('event_details.start !=', '');
      $query->where('event_details.end IS NOT NULL');
      $query->where('event_details.end !=', '');
      $result = $query->get()->getResult();

      header('Content-Type: application/json');
      echo json_encode([ 'items' => $result ]);exit;
    }

    public function get_locations_reached()
    {
      $event_id = (isset($_GET['event_id'])) ? $_GET['event_id'] : false;
      $where_event_id = $event_id ? " WHERE lr.event_id = $event_id " : '';
      // $query = $this->db->query(' SELECT lr.user_id, SUM(lr.points) AS total_points, u.name, u.surname, u.machine, u.size_of_wheel, events.name AS event_name 
      // FROM locations_reached lr 
      // JOIN locations l ON lr.location_id = l.id 
      // JOIN events ON lr.event_id = events.id 
      // JOIN users u ON lr.user_id = u.id 
      // WHERE lr.status <> "revoked" -- Condition to exclude revoked statuses
      // GROUP BY lr.user_id');
      // $results = $query->getResult();
      $query = $this->db->table('locations_reached lr')
                  ->select('lr.event_id, lr.user_id, SUM(lr.points) AS total_points, u.name, u.surname, u.machine, u.size_of_wheel, events.name AS event_name')
                  ->join('locations l', 'lr.location_id = l.id')
                  ->join('events', 'lr.event_id = events.id')
                  ->join('users u', 'lr.user_id = u.id')
                  ->where('lr.status !=', 'revoked')
                  ->groupBy('lr.user_id');
                if (isset($_GET['event_id'])) {
                    $event_id = $_GET['event_id'];
                    $query->where('lr.event_id', $event_id);
                }

      $result = $query->get()->getResult();

      header('Content-Type: application/json');
      echo json_encode([ 'locations' => $result ]);exit;
    }

    public function get_events_of_locations_reached()
    {
      $user_id = clean_input($_GET['user_id']);
      $query = $this->db->table('locations_reached')
         ->select('locations_reached.event_id, events.*')
         ->join('events', 'locations_reached.event_id = events.id')
         ->where('locations_reached.user_id', $user_id)
         ->groupBy('locations_reached.event_id')
         ->get();
      $result = $query->getResult();
      header('Content-Type: application/json');
      echo json_encode([ 'events' => $result ]);exit;
    }

    public function get_all_tracks()
    {
      if (!isset($_SESSION['id'])) {
        return redirect()->to(base_url('login'));
      }

      $today = date('Y-m-d'); // Get today's date
      $query = $this->db->query('SELECT e.name AS event_name, ed.id, ed.track, ed.start, ed.end, u.id AS user_id, u.name, u.surname, e.id AS event_id
                                FROM event_details ed
                                JOIN users u ON ed.user_id = u.id
                                JOIN events e ON ed.event_id = e.id
                                WHERE e.type = \'track\'
                                ORDER BY ed.id DESC
                                LIMIT 200');
      // INSTEAD OF TODAY TRACKS WE ARE GETTING ALL TRACKS SO COMMENTED OUT
      //  AND DATE(ed.start) = CURDATE()
      $results = $query->getResult();

      $query2 = $this->db->table('event_details')
                          ->select('event_details.*, CONCAT(users.name, " ", users.surname) as full_name')
                          ->join('users', 'event_details.user_id = users.id', 'left')
                          ->orderBy('event_details.ID', 'DESC')
                          ->limit(500)
                          ->get();

      $all_past_tracks = $query2->getResult();

      header('Content-Type: application/json');
      /*
        - ROWS is tracks for today
        - all tracks present , all tracks of past
      */
      echo json_encode([ 'rows' => $results, 'all_past_tracks' => $all_past_tracks ]);exit;
    }

    public function locations()
    {
      if (!isset($_SESSION['id'])) {
        return redirect()->to(base_url('login'));
      }
      
      if ($this->request->getGet('event_id')) {
        $selected_event = clean_input($this->request->getGet('event_id'));
        $event_model = new EventModel();
        
        $events = $event_model->where('type', 'orientation')->find();

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
        $events = $event_model->where('type', 'orientation')->find();
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

    public function locations_reached()
    {
      // if (isset($_POST['revoke_reason'])) {
        
      // }
      
      $all_participants = $this->db->table('users')->where('account_type', 'participant')->get()->getResult();
      $data = Array('participants' => $all_participants); 

      if (isset($_POST['revoke_reason'])) {
        $user_id = clean_input($_GET['user_id']);
        $revoke_reason = clean_input($_POST['revoke_reason']);
        $location_reached_id = clean_input($_POST['location_reached_id']);

        $this->db->table('locations_reached')
        ->where('id', $location_reached_id)
        ->update(Array(
          'revoke_reason' => $revoke_reason,
          'status' => 'revoked'
        ));

        return redirect()->to(base_url('organizer/locations/reached?user_id='.$user_id))->with('success', 'Status updated to revoked!');
      } else if (isset($_GET['user_id'])) {
        $user_id = clean_input($_GET['user_id']);
        $user = $this->db->table('users')->where('id', $user_id)->get()->getRow();
        if ($user == NULL) return redirect()->to(base_url('organizer/locations/reached'))->with('error', "User not found with id '$user_id'");

        $query = $this->db->table('locations_reached')
                ->select('locations_reached.*, locations_reached.date as lr_date, users.name, users.surname, events.name as event_name, locations.location')
                ->join('users', 'users.id = locations_reached.user_id')
                ->join('events', 'events.id = locations_reached.event_id')
                ->join('locations', 'locations.id = locations_reached.location_id')
                ->where('locations_reached.user_id', $user->id)
                ->orderBy('locations_reached.id', 'desc');
              if (isset($_GET['event_id'])) {
                  $event_id = $_GET['event_id'];
                  $query->where('locations_reached.event_id', $event_id);
              }
        $reached_locations = $query->get()->getResult();
        // echo '<pre>';
        // var_dump($reached_locations);
        // echo '</pre>';exit;
        $data['reached_locations'] = $reached_locations;

        // get_events_of_locations_reached


      }

      return view('organizer/includes/header')
                  .view('organizer/includes/sidebar')
                  .view('organizer/includes/topnavigation')
                  .view('organizer/locations_reached', $data)
                  .view('organizer/includes/footer');
    }

    public function generate_qr_code($url)
    {
      $image = md5($url.time()).'.png';
      require "includes/qrcode_generator/qaisar.php";
      
      return $image;
    }

    public function save_location()
    {
      if (!isset($_SESSION['id'])) {
        return redirect()->to(base_url('login'));
      }
      
      // echo FCPATH;exit;
      // $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $_POST['latitude_longitude_image']));
      // $img = $_POST['latitude_longitude_image']; // Your data 'data:image/png;base64,AAAFBfj42Pj4';
      // $img = str_replace('data:image/png;base64,', '', $img);
      // $img = str_replace(' ', '+', $img);
      // $data = base64_decode($img);

      // file_put_contents(FCPATH . "barcode_images/$barcode_image", $data);
      $event_id = clean_input($_POST['event_id']);
      $location = clean_input($_POST['location']); 
      $points = clean_input($_POST['points']); 
      // $latitude_longitude = clean_input($_POST['latitude_longitude']); 

      // $location_model = new LocationModel();
      // $location_model->insert(Array(
      //   'event_id' => $event_id,
      //   'location' => $location,
      //   'latitude_longitude' => $latitude_longitude,
      //   'points' => $points
      // ));

      $data = [
        'event_id' => $event_id,
        'location' => $location,
        // 'latitude_longitude' => $latitude_longitude,
        'points' => $points
      ];

      $this->db->table('locations')->insert($data);
      // $newId = $this->db->insertID();


      // $url = base_url('user/reached') . '?location_id='.$newId.'&event_id='.$_POST['event_id'].'&latitude_longitude='.$_POST['latitude_longitude'];
      // $barcode_image = $this->generate_qr_code($url);
      // 'barcode_image' => $barcode_image
      // $barcode_image_date = [
      //   'barcode_image' => $barcode_image
      // ];

      // $this->db->table('locations')->where('id', $newId)->update($barcode_image_date);


      return redirect()->to(base_url('organizer/locations?event_id='.$event_id))->with('success', 'Location saved successfully');
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
        return redirect()->to(base_url('organizer/locations?event_id='.$event))->with('success', 'Location deleted successfully');
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
        // $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $_POST['latitude_longitude_image']));
        // $img = $_POST['latitude_longitude_image']; // Your data 'data:image/png;base64,AAAFBfj42Pj4';
        // $img = str_replace('data:image/png;base64,', '', $img);
        // $img = str_replace(' ', '+', $img);
        // $data = base64_decode($img);

        // NOW UPDATE THE DATA
        // $barcode_image = time() . '-' .  generateRandomString(10) . '.png';

        // file_put_contents(FCPATH . "barcode_images/$barcode_image", $data);

        $location_id = clean_input($_POST['location_id']);
        $event_id = clean_input($_POST['event_id']);
        $location = clean_input($_POST['location']); 
        // $latitude_longitude = clean_input($_POST['latitude_longitude']); 
        $points = clean_input($_POST['points']);

        $location_model = new LocationModel();
        $location_model->update(['id' => $location_id], Array(
          'location' => $location,
          'points' => $points
          // 'latitude_longitude' => $latitude_longitude,
          // 'barcode_image' => $barcode_image
        ));

        return redirect()->to(base_url('organizer/locations?event_id='.$event_id))->with('success', 'Location updated successfully');
      }
    }
      
}