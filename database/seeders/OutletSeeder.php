<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OutletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $outlets = [
            [
                'name'      => 'FreshSoy Nagoya',
                'code'      => 'FSY-01',
                'address'   => 'Jl. Imam Bonjol, Nagoya, Batam',
                'phone'     => '0778-12345',
                'is_active' => true,
            ],
            [
                'name'      => 'FreshSoy Batam Centre',
                'code'      => 'FSY-02',
                'address'   => 'Jl. Engku Putri, Batam Centre, Batam',
                'phone'     => '0778-23456',
                'is_active' => true,
            ],
            [
                'name'      => 'FreshSoy Batu Aji',
                'code'      => 'FSY-03',
                'address'   => 'Jl. Brigjen Katamso, Batu Aji, Batam',
                'phone'     => '0778-34567',
                'is_active' => true,
            ],
        ];

        foreach ($outlets as $outlet) {
            \App\Models\Outlet::create($outlet);
        }
    }
}
