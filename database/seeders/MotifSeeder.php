<?php

namespace Database\Seeders;

use App\Models\Motif;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MotifSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Motif::create([
            'name' => 'BATIK'
        ]);

        Motif::create([
            'name' => 'TRIBAL'
        ]);

        Motif::create([
            'name' => 'HEXAGON'
        ]);
    }
}
