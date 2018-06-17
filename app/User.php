<?php

namespace App;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable as AuthenticalbleTrait;

class User extends Model implements Authenticatable
{
    use AuthenticalbleTrait;
    protected $fillable = ['email', 'reg_no', 'firstname', 'lastname', 'password', 'course_year', 'branch'];
}
