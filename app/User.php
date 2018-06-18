<?php

namespace App;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;

class User extends Model implements Authenticatable
{
    use AuthenticatableTrait;
    protected $fillable = ['email', 'reg_no', 'firstname', 'lastname', 'password', 'course_year', 'branch'];

    public function name(){
        return $this->firstname." ".$this->lastname;
    }

    public function dp(){
        if($pic = \App\ProfilePics::where('user_id', '=', $this->id)->first())
            return $pic->pic;
        return '/images/defaultdp.jpg';
    }

    public function cover(){
        if($pic = \App\CoverPics::where('user_id', '=', $this->id)->first())
            return $pic->pic;
        return '/images/defaultcover.jpg';
    }
}
