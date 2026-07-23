<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name'          => 'Admin User',
            'username'      => 'admin',
            'email'         => 'admin@kamssa.com',
            'password'      => Hash::make('Kamssa@2026'),
            'user_role'     => 'admin', // matches the enum('student','teacher','admin')
            'profile_id'    => null,    // no dedicated admins table exists yet
            'is_active'     => 1,
            'last_login_at' => null,
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);
    }
}