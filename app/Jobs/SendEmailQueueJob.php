<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\EmailSchedules;
use App\Models\UserSettings;
use App\Models\Leads;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Mail;
use App\Traits\UtilTrait;
use Config;

class SendEmailQueueJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, UtilTrait;

    public $emailData;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($emailData)
    {
        $this->emailData = $emailData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $emailData = $this->emailData;
        try{

            $body = $emailData->body;
            $subject = $emailData->subject;
            $userId = $emailData->created_by_id;
            $modelId = $emailData->id;
            $user_settings = UserSettings::find($userId);
            $email_signature = $user_settings->email_signature;
            $to_emails = explode(",",$emailData->emails);

            $body = View::make('email_template.index')->with(compact('body','email_signature'));

            if(env('APP_ENV') == 'local'){
                $to_emails = ['info@techwebsoft.com'];
            }

            $this->setMailConfig($userId);

            $status = Mail::html($body,function($message) use($subject,$to_emails,$body,$user_settings,$modelId){
                $message->to($to_emails)
                ->subject($subject)
                ->replyTo(Config::get('mail.from.address'))
                ->bcc($user_settings->bcc_name)
                ->from(Config::get('mail.from.address'),Config::get('mail.from.name'));

                $message->getHeaders()->addTextHeader('X-Model-ID',$modelId);
            });

            EmailSchedules::where('id',$emailData->id)->update(['delivery_status'=>'success']);
            Leads::where('id',$emailData->lead_id)->update(['status'=>$emailData->status]);
        } catch (\Exception $e){
            \Log::info("mail queue error");
            \Log::error($e);
            EmailSchedules::where('id',$emailData->id)->update(['delivery_status'=>'fail']);
        }
    }
}
