<?php

namespace App\Models;

use CodeIgniter\Model;

class EventRequestModel extends Model
{
    protected $table      = 'event_requests';
    protected $allowedFields = ['event_id', 'user_id', 'status', 'date'];
}