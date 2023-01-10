<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\SlackMessage;

class UpworkSlackNotification extends Notification
{
    use Queueable;
    public $message,$description,$url;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($message,$description,$url)
    {
        $this->message = $message;
        $this->description = $description;
        $this->url = $url;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['slack'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toSlack($notifiable)
    {
        \Log::info("toSlack");

        $message = $this->message;
        $description = $this->description;
        $url = $this->url;

        \Log::info($message);
        \Log::info($url);

        return (new SlackMessage)
            ->content($message)
            ->attachment(function ($attachment) use ($url,$message,$description) {
                $attachment->title($message, $url)
                        ->content($description);
            });
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
