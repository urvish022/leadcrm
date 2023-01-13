<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use jdavidbakr\MailTracker\Events\EmailSentEvent;
use App\Models\EmailSchedules;

class EmailSent
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(EmailSentEvent $event)
    {
        $tracker = $event->sent_email;
        $model_id = $event->sent_email->getHeader('X-Model-ID');
        \Log::info("email sent listener");
        \Log::info($tracker);
        \Log::info($model_id);

        EmailSchedules::where('id',$model_id)->update('tracking_id','');

    }
}
