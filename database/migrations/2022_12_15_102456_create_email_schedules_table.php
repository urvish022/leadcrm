<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lead_id')->index('lead_id');
            $table->foreign('lead_id')->references('id')->on('leads')
            ->onUpdate('NO ACTION')
            ->onDelete('NO ACTION');
            $table->string('emails',1000);
            $table->string('subject',1000);
            $table->text('body');
            $table->datetime('schedule_time');
            $table->string('status');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
            $table->dateTime('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('email_schedules');
    }
}
