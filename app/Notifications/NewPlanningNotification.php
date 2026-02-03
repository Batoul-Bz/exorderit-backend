<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewPlanningNotification extends Notification
{
    use Queueable;
    
    public $planning;
    public $comment;
    public function __construct($planning,$comment)
    {
        $this->planning=$planning;
        $this->comment=$comment;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toDatatbase($notifiable)
    {
        return [
            'title'=>'New planning',
            'message'=>'A new planning has been published',
            'shedule_id'=>$this->comment ?? null,
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
