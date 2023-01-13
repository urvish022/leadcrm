<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnInEmailScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('email_schedules', function (Blueprint $table) {
            $table->string('timezone')->after('body');
            $table->string('tracking_id')->nullable()->after('created_by_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('email_schedules', function (Blueprint $table) {
            $table->dropColumn('timezone');
            $table->dropColumn('tracking_id');
        });
    }
}
