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
        $admin = User::create([
            'name'      => 'Super Admin',
            'email'     => 'admin@freshsoy.com',
            'password'  => Hash::make('password'),
            'outlet_id' => null,
            'is_active' => true,
        ]);

        $admin->assignRole('admin');

        $manager = User::create([
            'name'      => 'Manager',
            'email'     => 'manager@freshsoy.com',
            'password'  => Hash::make('password'),
            'outlet_id' => null,
            'is_active' => true,
        ]);

        $manager->assignRole('manager');

        $cashier = User::create([
            'name'      => 'Cashier',
            'email'     => 'cashier@freshsoy.com',
            'password'  => Hash::make('password'),
            'outlet_id' => null,
            'is_active' => true,
        ]);

        $cashier->assignRole('cashier');
    }
}
