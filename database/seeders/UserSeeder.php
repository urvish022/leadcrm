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
            'name' => 'Urvish Patel',
            'email' => 'urvish31797@gmail.com',
            'password' => Hash::make('Urvish*36'),
        ],
        [
            'name' => 'Amish Patel',
            'email' => 'amishpatel61001@gmail.com',
            'password' => Hash::make('Urvish*36'),
        ]);
    }
}
