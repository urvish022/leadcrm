<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadEmailTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lead_email_templates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->index('leads_category_id');
            $table->foreign('category_id')->references('id')->on('lead_category')
            ->onUpdate('NO ACTION')
            ->onDelete('NO ACTION');
            $table->string('title');
            $table->string('subject');
            $table->longText('body');
            $table->string('keywords');
            $table->enum('email_type',['lead','followup1','followup2','thankyou'])->default('lead');
            $table->tinyInteger('default_status')->default(0)->comment('0:inactive,1:active');
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
        Schema::dropIfExists('lead_email_templates');
    }
}
