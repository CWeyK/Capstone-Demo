<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserCreated extends Notification implements ShouldQueue
{
    use Queueable;

    private $user;
    private $password;
    private $temporary;
    /**
     * Create a new notification instance.
     */
    public function __construct($user, $password, $temporary)
    {
        $this->user = $user;
        $this->password = $password;
        $this->temporary = $temporary;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = url(route('admin.login'));

        $mailMessage = (new MailMessage)
            ->subject('Ade Azhar | User Account Created')
            ->greeting('Welcome ' . $this->user->name . '!')
            ->line('Your account has been successfully created.')
            ->action('Log In', $url);

        if($this->temporary == true)
        {
            $mailMessage->line('Your temporary password is **' . $this->password . '** .')
            ->line('Please change your password as soon as possible.');
        }

        return $mailMessage;
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
