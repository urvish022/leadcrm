<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateColumnsInLeadActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leads_activities', function (Blueprint $table) {
            $table->dropColumn('from_status');
            $table->dropColumn('to_status');
            $table->string('updated_status')->after('lead_id');
            $table->string('reach_type')->after('updated_status')->nullable();
            $table->string('notes')->after('reach_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('leads_activities', function (Blueprint $table) {
            $table->dropColumn('updated_status');
            $table->dropColumn('reach_type');
            $table->dropColumn('notes');

            $table->string('from_status');
            $table->string('to_status');
        });
    }
}
