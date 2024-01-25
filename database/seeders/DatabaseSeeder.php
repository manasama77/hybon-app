<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            BarangJadiSeeder::class,
            MotifSeeder::class,
            TipeBarangSeeder::class,
            OrderFromSeeder::class,
            MasterBarangSeeder::class,
            // StockSeeder::class,
            MetodeMoldingSeeder::class,
            SubMoldingSeeder::class,
            // SalesOrderSeeder::class,
        ]);
    }
}
