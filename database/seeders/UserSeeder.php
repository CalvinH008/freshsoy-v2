<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = \App\Models\User::create([
            'name'      => 'Super Admin',
            'email'     => 'admin@freshsoy.com',
            'password'  => bcrypt('password'),
            'outlet_id' => null,
            'is_active' => true,
        ]);

        $admin->assignRole('admin');
    }
}
