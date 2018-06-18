<?php

namespace App;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Support\Facades\Auth;

class User extends Model implements Authenticatable
{
    use AuthenticatableTrait;
    protected $fillable = ['email', 'reg_no', 'firstname', 'lastname', 'password', 'course_year', 'branch'];

    public function id(){
        return $this->id;
    }

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

    public function friendRequests(){
        return $this->hasMany('App\FriendRequests', 'to');
    }

    public function getSuggestions(){
        $u = User::newQuery();
        $u->where('id', '!=', Auth::user()->id);
        $friendreqs = FriendRequest::where('from', '=', Auth::user()->id)->get();
        foreach ($friendreqs as $friendreq) {
            $u->where('id', '!=', $friendreq->to);
        }

        $friends = Friend::where('user_id', '=', Auth::user()->id)->get();

        foreach ($friends as $friend){
            $u->where('id', '!=', $friend->friend_id);
        }

        return $u;
    }
}
