<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\LeadEmailTemplate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Config;
use App\Traits\UtilTrait;

class WarmUpEmailCommand extends Command
{
    use UtilTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'warmup:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will send warmup-email';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $to_emails = ['urvish31797@gmail.com','info@techwebsoft.com','amishpatel61001@gmail.com','urvishpatel022@gmail.com','urvishandroideveloper@gmail.com'];

        $template = LeadEmailTemplate::find(1);
        $subject = $template->subject;
        $content = $template->body;

        $email_signature = view('email_template.signature');
        $body = View::make('email_template.index')->with(['body'=>$content,'email_signature'=>$email_signature]);

        if($this->setMailConfig(1)){
            Mail::html($body,function($message) use($subject,$to_emails,$body){
                $message->to($to_emails)
                ->subject($subject)
                ->replyTo(Config::get('mail.from.address'))
                ->from(Config::get('mail.from.address'),Config::get('mail.from.name'));
            });
        }

        if($this->setMailConfig(2)){
            Mail::html($body,function($message) use($subject,$to_emails,$body){
                $message->to($to_emails)
                ->subject($subject)
                ->replyTo(Config::get('mail.from.address'))
                ->from(Config::get('mail.from.address'),Config::get('mail.from.name'));
            });
        }
    }
}
