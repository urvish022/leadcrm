<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            [
                'name' => 'Urvish Patel',
                'email' => 'admin@mail.com',
                'password' => Hash::make('123456'),
            ],
            [
                'name' => 'Amish Patel',
                'email' => 'amishpatel61001@gmail.com',
                'password' => Hash::make('Urvish*36'),
            ]
        ]);
    }
}
