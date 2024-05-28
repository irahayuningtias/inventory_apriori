<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => "Admin", 
            'nik' => "123456789",
            'gender' => "Perempuan",
            'phone' => "081123456789",
            'address' => "Blitar",
            'email'=>"admin@gmail.com",  
            'password'=> Hash::make('123456'),
        ]);
    }
}
