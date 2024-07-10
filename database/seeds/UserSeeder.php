<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->insert([
            'name' => 'Manager',
            'email' =>'aaa@gmail.com',
            'password' => bcrypt('123456'),
        ]);
    }
}
