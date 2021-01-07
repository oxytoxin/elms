<?php

namespace App\Models;

use App\Models\Dean;
use App\Models\Role;
use App\Models\Todo;
use App\Models\Message;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\ProgramHead;
use App\Models\CalendarEvent;
use Carbon\Carbon;
use DB;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Laravel\Jetstream\HasProfilePhoto;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    protected $guarded = [];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function receivesBroadcastNotificationsOn()
    {
        return "users.$this->id";
    }

    public function todos()
    {
        return $this->hasMany(Todo::class);
    }

    public function dean()
    {
        return $this->hasOne(Dean::class);
    }
    public function program_head()
    {
        return $this->hasOne(ProgramHead::class);
    }
    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }
    public function student()
    {
        return $this->hasOne(Student::class);
    }
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
    public function calendar_events()
    {
        return $this->hasMany(CalendarEvent::class);
    }
    public function scopeIsStudent()
    {
        return (bool)Auth::user()->roles()->find(2);
    }
    public function scopeIsTeacher()
    {
        return (bool)Auth::user()->roles()->find(3);
    }
    public function scopeIsProgramHead()
    {
        return (bool)Auth::user()->roles()->find(4);
    }
    public function scopeIsDean()
    {
        return (bool)Auth::user()->roles()->find(5);
    }

    public function getRoleStringAttribute()
    {
        if ($this->isStudent()) {
            return 'student';
        }else if ($this->isTeacher()) {
            return 'teacher';
        }else if ($this->isProgramHead()) {
            return 'programhead';
        }else if ($this->isDean()) {
            return 'dean';
        }
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class,'sender_id');
    }
    public function receivedMessages()
    {
        return $this->hasMany(Message::class,'receiver_id');
    }

    public function getMessagesAttribute()
    {
        return $this->receivedMessages->merge($this->sentMessages)->sortByDesc('created_at');
    }

    public function contactMessages($contactId)
    {
        if($this->messages)
            return $this->messages->toQuery()->where('sender_id', $contactId)->orWhere('receiver_id',$contactId);
    }

    public function sendMessage($message, $contactId)
    {
        DB::transaction(function() use($message,$contactId)
        {
            Message::create([
                'sender_id' => Auth::id(),
                'receiver_id' => $contactId,
                'message' => $message,
            ]);
        });
    }

    public function getLastMessageAttribute()
    {
        return $this->messages->toQuery()->contact(Auth::id())->orderByDesc('created_at')->first();
    }

    public function unreadMessages()
    {
        return $this->messages->toQuery()->unread()->where('receiver_id', $this->id)->get();
    }

    public function getLatestMessagesAttribute()
    {
        return $this->messages->unique('complement_owner');
    }
}
