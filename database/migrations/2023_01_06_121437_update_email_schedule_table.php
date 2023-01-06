<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateEmailScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('email_schedules', function (Blueprint $table) {
            $table->unsignedBigInteger('created_by_id')->nullable()->after('lead_id');
            $table->foreign('created_by_id')->references('id')->on('users')
            ->onUpdate('NO ACTION')
            ->onDelete('NO ACTION');

            $table->enum('delivery_status',['pending','success','fail'])->default('pending')->after('status');

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
            $table->dropColumn('delivery_status');
            $table->dropColumn('created_by_id');
        });
    }
}
