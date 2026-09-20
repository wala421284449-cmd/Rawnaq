<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GeneralNotification extends Notification
{
    use Queueable;

    protected $title;
    protected $message;

    // استقبال العنوان والرسالة عند إنشاء الإشعار
    public function __construct($title, $message)
    {
        $this->title = $title;
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['database']; // تخزين في قاعدة البيانات ليظهر في الجرس
    }

    public function toArray($notifiable)
    {
        return [
            'title'   => $this->title,
            'message' => $this->message,
        ];
    }
}
