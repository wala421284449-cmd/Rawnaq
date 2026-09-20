<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LoginNotification extends Notification
{
    use Queueable;

    public $loginTime;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        // حفظ وقت تسجيل الدخول الحالي
        $this->loginTime = now()->format('Y-m-d H:i:s');
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // نحدد القناة هنا وهي البريد الإلكتروني (Mail)
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('تنبيه أمني: تسجيل دخول جديد إلى حسابك في متجر رونق')
            ->greeting('مرحباً ' . $notifiable->name . '،')
            ->line('لقد تم تسجيل الدخول بنجاح إلى حسابك في لوحة تحكم متجر رونق.')
            ->line('وقت تسجيل الدخول: ' . $this->loginTime)
            ->line('إذا لمש تكن أنت من قام بهذا الإجراء، يرجى تأمين حسابك فوراً.')
            ->salutation('مع تحيات فريق إدارة متجر رونق');
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
