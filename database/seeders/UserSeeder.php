<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(20)->create();
        User::create([
            'name' => 'Agusti Gunawan',
            'email' => 'agustig@agustig.dev',
            'phone' => '628223524675',
            'role' => 'admin',
            'bio' => 'dev',
            'email_verified_at' => now(),
            'password' => Hash::make('passwd123'),
        ]);
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@agustig.dev',
            'phone' => '628223524678',
            'role' => 'super_admin',
            'bio' => 'dev admin',
            'email_verified_at' => now(),
            'password' => Hash::make('passwd123'),
        ]);
    }
}
