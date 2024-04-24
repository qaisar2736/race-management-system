<?php

namespace App\Models;

use CodeIgniter\Model;

class LocationModel extends Model
{
    protected $table      = 'locations';
    protected $allowedFields = ['event_id', 'location', 'latitude_longitude', 'barcode_image', 'points'];
}