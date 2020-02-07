<?php

use HamzaApp\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user = new User();
        $user->password = Hash::make('oussama1234');
        $user->email = 'benounnas@gmail.com';
        $user->name = 'wiwi wiwi';
        $user->save();
    }
}
