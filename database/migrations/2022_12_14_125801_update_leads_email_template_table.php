<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateLeadsEmailTemplateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE lead_email_templates MODIFY email_type ENUM('lead','initial','followup1','followup2','followup3','followup4','followup5','thankyou')");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE lead_email_templates MODIFY email_type ENUM('lead','followup1','followup2','thankyou')");
    }
}
