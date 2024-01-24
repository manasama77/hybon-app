<?php

namespace Database\Seeders;

use App\Models\SalesOrder;
use App\Models\SalesOrderSeq;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SalesOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SalesOrder::create([
            'code_order'        => '202401200001',
            'title'             => 'CARBON VELG AEROX 2033',
            'motif_id'          => 1,
            'metode'            => 'pure',
            'dp'                => 500000,
            'harga_jual'        => 2000000,
            'barang_jadi_id'    => 1,
            'nama_customer'     => 'DONI WAHYUDI',
            'alamat'            => 'JL. BUNTU NO 69',
            'order_from_id'     => 2,
            'no_telp'           => '082114578976',
            'status'            => 'sales order',
            'notes'             => null,
            'sub_molding_id'    => null,
            'cost_molding_pure' => null,
            'created_by'        => 1,
            'updated_by'        => 1,
        ]);

        SalesOrderSeq::create(['seq' => 1]);
    }
}
