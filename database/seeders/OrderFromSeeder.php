<?php

namespace Database\Seeders;

use App\Models\OrderFrom;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderFromSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OrderFrom::create([
            'name' => 'TIKTOK',
        ]);

        OrderFrom::create([
            'name' => 'SHOPEE',
        ]);

        OrderFrom::create([
            'name' => 'TOKPED',
        ]);
    }
}
