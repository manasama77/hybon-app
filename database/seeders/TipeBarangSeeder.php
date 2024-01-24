<?php

namespace Database\Seeders;

use App\Models\TipeBarang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipeBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TipeBarang::create([
            'name' => 'CARBON',
        ]);

        TipeBarang::create([
            'name' => 'UTILITY',
        ]);
    }
}
