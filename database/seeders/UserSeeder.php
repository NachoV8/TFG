<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Nacho Villa',
            'email' => 'nachovilla8@gmail.com',
            'password' => 'Prueba1234'
        ])->assignRole('admin');
    }
}
