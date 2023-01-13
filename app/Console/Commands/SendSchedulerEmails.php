<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\EmailScheduleRepository;
use App\Models\EmailSchedules;
use Carbon\Carbon;
use Illuminate\Contracts\Bus\Dispatcher;
use App\Jobs\SendEmailQueueJob;

class SendSchedulerEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:scheduler_emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This cron will run at every minute and send emails';

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
        $all_timezones = ['America/New_York','Europe/London','Australia/Sydney','Africa/Johannesburg','America/Vancouver','Asia/Kolkata'];
        foreach($all_timezones as $timezone){
            date_default_timezone_set($timezone);
            $start = Carbon::now();
            $end = Carbon::now()->addMinutes(2);

            $scheduleData = EmailSchedules::whereBetween('schedule_time',[$start,$end])
            ->where('timezone',$timezone)
            ->where('delivery_status','pending')
            ->get();

            foreach($scheduleData as $value){

                $body = $value->body;
                $to_emails = $value->emails;

                return app(Dispatcher::class)->dispatch(new SendEmailQueueJob($value));
            }
        }
    }
}
