<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chatroom extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $appends = ['receiver'];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function members()
    {
        return $this->belongsToMany(User::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class)->latest();
    }

    public function latestMessage()
    {
        return $this->belongsTo(Message::class);
    }

    public function scopeWithLatest($query)
    {
        return $query->addSelect(['latest_message_id' => Message::select('id')
            ->whereColumn('chatrooms.id', 'chatroom_id')
            ->latest()
            ->take(1)])->with('latestMessage');
    }

    public function getReceiverAttribute()
    {
        $id = auth()->id();
        return $this->members->where('user_id', '!=', $id)->first();
    }
}
