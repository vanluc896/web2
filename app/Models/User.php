<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'staff_code',
        'username',
        'email',
        'password',
        'fullname',
        'role',
        'remember_token',
    ];
}
