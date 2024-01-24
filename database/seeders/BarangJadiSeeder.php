<?php

namespace Database\Seeders;

use App\Models\BarangJadi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BarangJadiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BarangJadi::create([
            'name'       => 'SPAKBOARD MIO',
            'harga_jual' => 2000000,
        ]);
    }
}
