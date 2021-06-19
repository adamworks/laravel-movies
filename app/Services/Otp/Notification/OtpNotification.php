<?php

namespace App\Services\Otp\Notification;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Core\Support\Notification\ZenzivaSms\ZenzivaSmsMaskingChannel;

class OtpNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [ZenzivaSmsMaskingChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toZenzivaSmsMasking($notifiable)
    {
    	return [
    		'phone_number' => $notifiable->phone_number,
    		'message' => $this->getMessage($notifiable),
            'otp' => true,
    	];
    }

    private function getMessage($notifiable)
    {
    	return sprintf("Demi keamanan akun Anda, mohon TIDAK MEMBERIKAN OTP kepada siapapun termasuk tim Freshbox. OTP berlaku 15 mnt: %s", $notifiable->otp);
    }
}