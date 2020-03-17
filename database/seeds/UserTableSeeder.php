<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $user  = new \App\User();
        $user->name = "Admin";
        $user->email = "admin@anuz.com";
        $user->password = bcrypt('secret');
        $user->isAdmin = true;
        $user->save();
    }
}
