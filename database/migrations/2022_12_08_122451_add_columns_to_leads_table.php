<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->string('total_employees')->nullable()->after('company_website');
            $table->string('industry_type')->nullable()->after('total_employees');
            $table->string('company_email')->nullable()->after('company_name');
            $table->string('company_phone_number')->nullable()->after('company_email');
            $table->string('facebook_url')->nullable()->after('total_employees');
            $table->string('linkedin_url')->nullable()->after('facebook_url');
            $table->string('twitter_url')->nullable()->after('linkedin_url');
            $table->string('company_state')->nullable()->after('company_origin');
            $table->string('company_city')->nullable()->after('company_state');
            $table->string('company_address')->nullable()->after('company_city');
            $table->string('annual_revenue')->nullable()->after('company_address');
            $table->string('keywords',1000)->nullable()->after('annual_revenue');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn(['total_employees','industry_type','company_email','company_phone_number','linkedin_url','facebook_url','twitter_url','company_address','company_city','company_state','annual_revenue','keywords']);
        });
    }
}
