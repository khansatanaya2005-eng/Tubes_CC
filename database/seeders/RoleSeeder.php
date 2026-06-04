<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'Admin Utama',
            'username' => 'admin_super',
            'nama_lengkap' => 'Administrator',
            'email' => 'superadmin@tracif.com',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);
        
        \App\Models\User::factory()->create([
            'name' => 'Kasir 1',
            'username' => 'kasir_1',
            'nama_lengkap' => 'Kasir Depan',
            'email' => 'kasir@tracif.com',
            'password' => bcrypt('password'),
            'role' => 'kasir'
        ]);
        
        \App\Models\User::factory()->create([
            'name' => 'User Biasa',
            'username' => 'user_biasa',
            'nama_lengkap' => 'Pengguna Umum',
            'email' => 'user@tracif.com',
            'password' => bcrypt('password'),
            'role' => 'user'
        ]);
    }
}
