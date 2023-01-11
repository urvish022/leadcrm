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
    public $title,$description,$url;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($title,$description,$url)
    {
        $this->title = $title;
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
        $title = addslashes($this->title);
        $description = addslashes(strip_tags($this->description));
        $url = addslashes($this->url);

        return (new SlackMessage)
            ->content($title)
            ->attachment(function ($attachment) use ($url,$title,$description) {
                $attachment->title($title, $url)
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
