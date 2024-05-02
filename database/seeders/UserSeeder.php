<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            'id' => 1,
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'role_id' => 4,
            'password' => Hash::make('password'),
        ]);
        DB::table('users')->insert([
            'id' => 2,
            'name' => 'Giovanni',
            'email' => 'giovanni@example.com',
            'role_id' => 4,
            'password' => Hash::make('password'),
        ]);
        DB::table('users')->insert([
            'id' => 3,
            'name' => 'Test user',
            'email' => 'testuser@example.com',
            'role_id' => 2,
            'password' => Hash::make('password'),
        ]);
    }
}
