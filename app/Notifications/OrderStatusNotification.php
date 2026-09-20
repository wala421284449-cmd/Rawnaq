<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderStatusNotification extends Notification
{
    use Queueable;

    public $order;
    public $messageText;

    /**
     * Create a new notification instance.
     */
    public function __construct($order)
    {
        $this->order = $order;
        $this->messageText = 'تم تحديث حالة الطلب رقم #' . $order->id . ' بنجاح.';
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // نحدد القناة هنا لتكون قاعدة البيانات (database)
        return ['database'];
    }

    /**
     * Get the array representation of the notification for database storage.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'title' => 'تحديث حالة الطلب',
            'message' => $this->messageText,
            'time' => now()->toTimeString(),
        ];
    }
}
