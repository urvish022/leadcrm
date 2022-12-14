<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateLeadsStatusField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE leads MODIFY status ENUM('scrapped','lead','initial','followup1','followup2','followup3','followup4','followup5','hold','interested','in','out','invalid')");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE leads MODIFY status ENUM('scrapped','lead','followup1','followup2','hold','in','out','invalid')");
    }
}
