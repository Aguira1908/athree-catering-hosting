<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Customer;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed untuk User default Laravel
        User::create([
            'name' => 'User Biasa',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
        ]);

        // Seed untuk Customer (Karena sistem utama menggunakan tabel customer)
        Customer::create([
            'nama' => 'Customer Satu',
            'email' => 'customer@example.com',
            'password' => Hash::make('password'),
            'alamat' => 'Jl. Mawar No 1',
            'no_hp' => '081234567890'
        ]);
    }
}
