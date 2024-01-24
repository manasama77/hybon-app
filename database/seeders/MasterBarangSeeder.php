<?php

namespace Database\Seeders;

use App\Models\MasterBarang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasterBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MasterBarang::create([
            'kode_barang'    => 'CARB',
            'nama_barang'    => 'CARBON BATIK',
            'tipe_barang_id' => 1,
            'nama_vendor'    => 'test vendor',
            'tipe_stock'     => 'lembar',
            'satuan'         => 'cm',
            'harga_jual'     => 100000,
            'created_by'     => 1,
            'updated_by'     => 1,
        ]);

        MasterBarang::create([
            'kode_barang'    => 'KUAS',
            'nama_barang'    => 'KUAS',
            'tipe_barang_id' => 2,
            'nama_vendor'    => 'test vendor',
            'tipe_stock'     => 'satuan',
            'satuan'         => 'pcs',
            'harga_jual'     => 1000,
            'created_by'     => 1,
            'updated_by'     => 1,
        ]);
    }
}
