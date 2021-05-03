<?php

namespace App\Models;

use Carbon\Carbon;
use DB;
use Hash;
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
        'shortname',
    ];

    public function receivesBroadcastNotificationsOn()
    {
        return "users.$this->id";
    }

    public function getShortnameAttribute()
    {
        return trim(explode(",", $this->name)[1]);
    }

    public function todos()
    {
        return $this->hasMany(Todo::class);
    }

    public function orientations()
    {
        return $this->hasMany(Orientation::class);
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

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
    public function calendar_events()
    {
        return $this->hasMany(CalendarEvent::class);
    }
    public function chatrooms()
    {
        return $this->belongsToMany(Chatroom::class);
    }
    public function supports()
    {
        return $this->hasMany(Support::class)->orderByDesc('created_at');
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
        } else if ($this->isTeacher()) {
            return 'teacher';
        } else if ($this->isProgramHead()) {
            return 'programhead';
        } else if ($this->isDean()) {
            return 'dean';
        }
    }

    public function getUnreadSupportAttribute()
    {
        return $this->supports()->whereReadAt(null)->get();
    }

    public function readSupports()
    {
        $this->unread_support->toQuery()->update([
            'read_at' => Carbon::now()
        ]);
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }
    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function getMessagesAttribute()
    {
        return $this->receivedMessages->merge($this->sentMessages)->sortByDesc('created_at');
    }

    public function contactMessages($contactId)
    {
        $messages = $this->messages->filter(fn ($m) => $m->complement_owner->id == $contactId);
        if ($messages->count()) return $messages->toQuery();
        return collect();
    }

    public function sendMessage($message, $contactId)
    {
        DB::transaction(function () use ($message, $contactId) {
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
