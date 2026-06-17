<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Nadia Erraji',
            'email' => 'admin@smartsol.com',
            'password' => Hash::make('passwordnadia'),
            'phone_number' => '0716715580', 
        ]);
    }
}