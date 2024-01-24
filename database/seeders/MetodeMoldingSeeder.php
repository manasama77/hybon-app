<?php

namespace Database\Seeders;

use App\Models\MetodeMolding;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MetodeMoldingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MetodeMolding::create([
            'name' => 'Metode Molding A',
        ]);

        MetodeMolding::create([
            'name' => 'Metode Molding B',
        ]);

        MetodeMolding::create([
            'name' => 'Metode Molding C',
        ]);
    }
}
