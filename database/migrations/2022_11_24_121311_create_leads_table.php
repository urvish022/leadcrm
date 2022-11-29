<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by_id');
            $table->foreign('created_by_id')->references('id')->on('users')
            ->onUpdate('NO ACTION')
            ->onDelete('NO ACTION');
            $table->unsignedBigInteger('category_id')->index('leads_category_id');
            $table->foreign('category_id')->references('id')->on('lead_category')
            ->onUpdate('NO ACTION')
            ->onDelete('NO ACTION');
            $table->string('company_name');
            $table->string('company_website');
            $table->string('company_origin');
            $table->enum('reach_type',['email','call','facebook','linkedin','other'])->default('email');
            $table->enum('status',['scrapped','lead','followup1','followup2','hold','in','out','invalid'])->default('scrapped');
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
        Schema::dropIfExists('leads');
    }
}
