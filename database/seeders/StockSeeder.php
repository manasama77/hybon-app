<?php

namespace Database\Seeders;

use App\Models\Stock;
use App\Models\StockMonitor;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        $dt  = $now->format('Ymd');

        StockMonitor::create([
            'kode_barang'      => 'CARB-' . $dt . '-1-0',
            'master_barang_id' => 1,
            'tipe_stock'       => 'lembar',
            'panjang'          => 100,
            'lebar'            => 50,
            'qty'              => 0,
            'harga_jual'       => 1000000,
            'created_by'       => 1,
            'updated_by'       => 1,
        ]);
        Stock::create([
            'kode_barang'      => 'CARB-' . $dt . '-1-0',
            'stock_monitor_id' => 1,
            'tipe_stock'       => 'lembar',
            'panjang'          => 100,
            'lebar'            => 50,
            'qty'              => 0,
            'harga_jual'       => 1000000,
            'status'           => 'in',
            'created_by'       => 1,
            'updated_by'       => 1,
        ]);

        StockMonitor::create([
            'kode_barang'      => 'KUAS-' . $dt,
            'master_barang_id' => 2,
            'tipe_stock'       => 'satuan',
            'panjang'          => 0,
            'lebar'            => 0,
            'qty'              => 100,
            'harga_jual'       => 1000,
            'created_by'       => 1,
            'updated_by'       => 1,
        ]);
        Stock::create([
            'kode_barang'      => 'KUAS-' . $dt,
            'stock_monitor_id' => 2,
            'tipe_stock'       => 'satuan',
            'panjang'          => 0,
            'lebar'            => 0,
            'qty'              => 100,
            'harga_jual'       => 1000,
            'status'           => 'in',
            'created_by'       => 1,
            'updated_by'       => 1,
        ]);
    }
}
