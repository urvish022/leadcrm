<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserSettings;

class UserSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserSettings::truncate();
        UserSettings::insert([
                [
                    'user_id'=>1,
                    'followup_interval_days'=>3,
                    'mail_type'=>'smtp',
                    'mail_host'=>'smtp.sendgrid.net',
                    'mail_port'=>'587',
                    'mail_username'=>'apikey',
                    'mail_password'=>'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',
                    'mail_encryption'=>'tls',
                    'mail_from_address'=>'urvish.patel@techwebsoft.com',
                    'mail_from_name'=>'Urvish Patel',
                    'bcc_name'=>"customer@techwebsoft.com",
                ],
                [
                    'user_id'=>2,
                    'followup_interval_days'=>2,
                    'mail_type'=>'',
                    'mail_host'=>'',
                    'mail_port'=>'',
                    'mail_username'=>'',
                    'mail_password'=>'',
                    'mail_encryption'=>'',
                    'mail_from_address'=>'',
                    'mail_from_name'=>'',
                    'bcc_name'=>"",
                ]
        ]);
    }
}
