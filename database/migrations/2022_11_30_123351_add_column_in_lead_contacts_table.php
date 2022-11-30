<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnInLeadContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lead_contacts', function (Blueprint $table) {
            $table->tinyInteger('status')->after('linkedin_profile')->comment('0:inactive,1:active')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lead_contacts', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
