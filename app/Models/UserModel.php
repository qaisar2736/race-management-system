<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $allowedFields = ['name', 'surname', 'email', 'mobile_number', 'password', 'account_type', 'email_confirmation_code', 'forgot_password_code', 'email_verified', 'temp_email', 'machine', 'size_of_wheel', 'have_winch'];
}