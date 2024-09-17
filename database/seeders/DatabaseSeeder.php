<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'username' => 'admin',
            'name' => 'admin',
            'role' => 'admin',
            'password' => bcrypt('password123'),
        ]);

        DB::table('users')->insert([
            'username' => 'operator',
            'name' => 'operator',
            'role' => 'operator',
            'password' => bcrypt('password123'),
        ]);
    }
}
