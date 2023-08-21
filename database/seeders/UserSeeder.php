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
        User::factory(5)->create();
        User::create([
            'name' => 'Agusti Gunawan',
            'email' => 'superuser@agustig.dev',
            'email_verified_at' => now(),
            'password' => Hash::make('passwd123'),
        ]);
    }
}
