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

    public function blockList(){
        $relations = $this->hasMany('App\BlockedUser', 'by')->get();
        $blocks = array();

        foreach ($relations as $relation){
            array_push($blocks, User::where('id', $relation->who)->first());
        }

        return $blocks;
    }

    public function friends(){
        $relations = $this->hasMany('App\Friend', 'user_id')->get();
        $friends = array();

        foreach ($relations as $relation){
            array_push($friends, User::where('id', $relation->friend_id)->first());
        }

        return $friends;
    }

    public function friendRequests($offset = 0, $limit = 6){
        $reqs = $this->hasMany('App\FriendRequest', 'to')->offset($offset)->limit($limit)->get();
        $result = array();

        foreach ($reqs as $req){
            array_push($result, User::where('id', $req->from)->first());
        }

        return $result;
    }

    public function sentRequests($offset = 0, $limit = 6){
        $reqs = $this->hasMany('App\FriendRequest', 'from')->offset($offset)->limit($limit)->get();
        $result = array();

        foreach ($reqs as $req) {
            array_push($result, User::where('id', $req->to)->first());
        }

        return $result;
    }

    public function getSuggestions($offset = 0, $limit = 6){
        $u = User::newQuery();
        $u->where('id', '!=', Auth::user()->id);

        $friendreqs = FriendRequest::where('from', '=', Auth::user()->id)->get();
        foreach ($friendreqs as $friendreq) {
            $u->where('id', '!=', $friendreq->to);
        }

        $blockedusers = BlockedUser::where('by', Auth::user()->id)->get();

        foreach ($blockedusers as $blockeduser) {
            $u->where('id', '!=', $blockeduser->who);
        }

        $blockedusers = BlockedUser::where('who', Auth::user()->id)->get();

        foreach ($blockedusers as $blockeduser) {
            $u->where('id', '!=', $blockeduser->by);
        }

        $friends = Friend::where('user_id', '=', Auth::user()->id)->get();

        foreach ($friends as $friend){
            $u->where('id', '!=', $friend->friend_id);
        }

        return $u->offset($offset)->limit($limit)->get();
    }

    public function isBlocked($id){
        return BlockedUser::where(['by' => Auth::user()->id, 'who' => $id])->count() > 0;
    }

    public function isFriend($id){
        return Friend::where(['user_id' => Auth::user()->id, 'friend_id' => $id])->count() > 0;
    }

    public function isRequested($id){
        return FriendRequest::where(['from' => Auth::user()->id, 'to' => $id])->count() > 0;
    }

    public function requestedMe($id){
        return FriendRequest::where(['from' => $id, 'to' => Auth::user()->id])->count() > 0;
    }

    public function friendsBtnFor($id){
        if($this->isFriend($id)){
            return "<a data-id='$id' class='action unfriend'>Unfriend <i class='mdi mdi-18px mdi-account-minus'></i> </a>";
        }
        else if($this->isRequested($id)){
            return "<a data-id='$id' class='action cancel'>Cancel request <i class='mdi mdi-18px mdi-account-remove'></i></a>";
        }
        else if($this->requestedMe($id)){
            return "<a data-id='$id' class='action accept'>Accept <i class='mdi mdi-18px mdi-account-plus'></i></a>&nbsp;
                    <a data-id='$id' class='action reject'>Reject <i class='mdi mdi-18px mdi-account-remove'></i></a>";
        }
        else if($this->isBlocked($id)) {
            return "<a data-id='$id' class='action unblock'>Unblock</i> </a>";
        }
        else{
            return "<a data-id='$id' class='action add-friend'>Add friend <i class='mdi mdi-18px mdi-account-plus'></i> </a>";
        }
    }

    public function posts(){
        return $this->hasMany('App\Post', 'user_id', 'id');
    }
}
