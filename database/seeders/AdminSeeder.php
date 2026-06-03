<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'Admin.123@gmail.com',
            'password' => bcrypt('Admin.123'),
            'role' => 'admin',
            'gender' => 'Male',
            'address' => 'Admin Office',
        ]);
    }
}
