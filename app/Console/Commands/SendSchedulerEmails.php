<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\EmailScheduleRepository;

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
        // EmailScheduleRepository::where('')
        return 0;
    }
}
