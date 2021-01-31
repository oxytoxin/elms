<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;

    public $guarded = [];
    protected $dates = ['read_at'];
    protected $appends = ['complement_owner','user_role'];

    public function sender()
    {
        return $this->belongsTo(User::class,'sender_id');
    }
    public function receiver()
    {
        return $this->belongsTo(User::class,'receiver_id');
    }

    public function scopeContact($query, User $user)
    {
        $query->where('sender_id', Auth::id())->where('receiver_id',$user->id)->orWhere('receiver_id',Auth::id())->where('sender_id',$user->id);
    }

    public function getComplementOwnerAttribute()
    {
        if(Auth::id() == $this->sender_id)  return  User::find($this->receiver_id);
        else return User::find($this->sender_id);
    }

    public function getUserRoleAttribute()
    {
        if(Auth::id() == $this->sender_id)  return  'sender';
        else return 'receiver';
    }

    public function scopeUnread($query)
    {
        $query->whereNull('read_at');
    }

}
