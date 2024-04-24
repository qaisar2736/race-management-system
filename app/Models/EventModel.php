<?php

namespace App\Models;

use CodeIgniter\Model;

class EventModel extends Model
{
    protected $table      = 'events';
    protected $allowedFields = ['name', 'type', 'hours', 'minutes', 'date', 'created_by'];
}