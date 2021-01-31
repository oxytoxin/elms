<?php

namespace App\Http\Livewire;

use Livewire\Component;

class NotificationComponent extends Component
{

    public $notifications;
    public $unread;
    public $showNotifs = false;
    public $user_id;

    protected $listeners = [];

    public function mount()
    {
        $this->user_id = auth()->user()->id;
    }

    public function getListeners()
    {
        return [
            "echo-private:users.{$this->user_id},.Illuminate\Notifications\Events\BroadcastNotificationCreated" => 'newNotification',
        ];
    }
    public function render()
    {
        $this->notifications = auth()->user()->notifications;
        $this->unread = auth()->user()->unreadNotifications->count();
        return view('livewire.notification-component');
    }

    public function newNotification()
    {
        $this->dispatchBrowserEvent('notification');
    }

    public function notificationsOpened()
    {
        auth()->user()->unreadNotifications->markAsRead();
        $this->showNotifs = !$this->showNotifs;
    }
}
