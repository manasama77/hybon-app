<?php

namespace Database\Seeders;

use App\Models\Stock;
use App\Models\StockMonitor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StockMonitor::create([
            'kode_barang'      => 'CARB-20240120-1',
            'master_barang_id' => 1,
            'tipe_stock'       => 'lembar',
            'panjang'          => 100,
            'lebar'            => 50,
            'qty'              => 0,
            'created_by'       => 1,
            'updated_by'       => 1,
        ]);
        Stock::create([
            'kode_barang'      => 'CARB-20240120-1',
            'master_barang_id' => 1,
            'tipe_stock'       => 'lembar',
            'panjang'          => 100,
            'lebar'            => 50,
            'qty'              => 0,
            'status'           => 'in',
            'created_by'       => 1,
            'updated_by'       => 1,
        ]);

        StockMonitor::create([
            'kode_barang'      => 'KUAS-20240120',
            'master_barang_id' => 2,
            'tipe_stock'       => 'satuan',
            'panjang'          => 0,
            'lebar'            => 0,
            'qty'              => 100,
            'created_by'       => 1,
            'updated_by'       => 1,
        ]);
        Stock::create([
            'kode_barang'      => 'KUAS-20240120',
            'master_barang_id' => 2,
            'tipe_stock'       => 'satuan',
            'panjang'          => 0,
            'lebar'            => 0,
            'qty'              => 100,
            'status'           => 'in',
            'created_by'       => 1,
            'updated_by'       => 1,
        ]);
    }
}
