<?php

namespace App\Console\Commands;

use App\Models\Leads;
use Illuminate\Console\Command;

class ChangeStatusLeadType extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:lead-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will update status of leads';

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
        Leads::where('status','lead')->update(['status'=>'initial']);
        return 0;
    }
}
