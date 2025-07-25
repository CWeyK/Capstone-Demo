<?php

namespace App\Notifications;

use App\Models\ClassGroup;
use App\Models\ClassReplacement;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CancelClassNotification extends Notification
{
    use Queueable;

    public ClassGroup $classGroup;
    public ClassReplacement $replacement;
    /**
     * Create a new notification instance.
     */
    public function __construct(ClassGroup $classGroup, ClassReplacement $replacement)
    {
        $this->classGroup = $classGroup;
        $this->replacement = $replacement;
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

        $mailMessage = (new MailMessage)
            ->subject('Class Cancellation Notice')
            ->line('Your ' 
            . $this->classGroup->subjectClass->class_type 
            . ' Class for ' 
            . $this->classGroup->subjectClass->subject->name 
            . ' on '
            . $this->replacement->date
            . ' has been cancelled.')
            ->salutation('');

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
