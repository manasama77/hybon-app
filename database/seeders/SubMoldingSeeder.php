<?php

namespace Database\Seeders;

use App\Models\SubMolding;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubMoldingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SubMolding::create([
            'metode_molding_id' => 1,
            'name' => 'Sub A1',
        ]);
        SubMolding::create([
            'metode_molding_id' => 1,
            'name' => 'Sub A2',
        ]);
        SubMolding::create([
            'metode_molding_id' => 1,
            'name' => 'Sub A3',
        ]);

        SubMolding::create([
            'metode_molding_id' => 2,
            'name' => 'Sub B1',
        ]);
        SubMolding::create([
            'metode_molding_id' => 2,
            'name' => 'Sub B2',
        ]);
        SubMolding::create([
            'metode_molding_id' => 2,
            'name' => 'Sub B3',
        ]);

        SubMolding::create([
            'metode_molding_id' => 3,
            'name' => 'Sub C1',
        ]);
        SubMolding::create([
            'metode_molding_id' => 3,
            'name' => 'Sub C2',
        ]);
        SubMolding::create([
            'metode_molding_id' => 3,
            'name' => 'Sub C3',
        ]);
    }
}
