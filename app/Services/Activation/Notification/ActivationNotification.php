<?php

namespace App\Services\Activation\Notification;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
//use App\Foundation\Support\EmailTemplate\EmailTemplateFactory;

class ActivationNotification extends Notification
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
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $emailTemplateFactory = resolve(EmailTemplateFactory::class);

        $option = 'email:user:registered';

        $args = [
            'fullname' => $notifiable->name,
            'url' => $notifiable->activation->url()
        ];
        
        $defaultTemplate = [
            'name' => 'Pendaftaran User Baru',
            'subject' => 'Anda telah terdafatar Dalam Sistem',
            'content' => view('emails.defaults.user.registered')->render(),
        ];

        return $emailTemplateFactory->notification($option, $args, $defaultTemplate);
    }

}
