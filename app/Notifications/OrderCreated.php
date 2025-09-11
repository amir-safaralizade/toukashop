<?php

// app/Notifications/OrderCreated.php

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage; // اگر از nexmo (یا sms.ir یا kavenegar) استفاده کنی

class OrderCreated extends Notification
{
    use Queueable;

    public function __construct(public \App\Models\Order $order) {}

    public function via($notifiable)
    {
        return ['mail']; // یا ['mail', 'nexmo'] اگر SMS هم بخوای
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('سفارش شما ثبت شد')
            ->line('سفارش شما با شماره ' . $this->order->id . ' با موفقیت ثبت شد.')
            ->line('مبلغ قابل پرداخت: ' . number_format($this->order->final_price) . ' تومان')
            ->action('مشاهده سفارش', url('/user/orders/' . $this->order->id));
    }

    // برای پیامک اگر لازم شد
    public function toNexmo($notifiable)
    {
        return (new NexmoMessage)
            ->content('سفارش #' . $this->order->id . ' ثبت شد. مبلغ: ' . number_format($this->order->final_price) . ' تومان');
    }
}
