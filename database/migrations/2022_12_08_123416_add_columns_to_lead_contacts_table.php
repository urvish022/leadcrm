<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToLeadContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lead_contacts', function (Blueprint $table) {
            $table->string('title')->nullable()->after('last_name');
            $table->string('email_status')->nullable()->after('email');
            $table->string('phone')->nullable()->after('email_status');
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
           $table->dropColumn(['title','email_status','phone']);
        });
    }
}
