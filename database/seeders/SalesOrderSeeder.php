<?php

namespace Database\Seeders;

use App\Models\SalesOrder;
use App\Models\SalesOrderSeq;
use App\Models\TrackingLog;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SalesOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        $dt  = $now->format('Ymd');

        SalesOrder::create([
            'code_order'        => $dt . '0001',
            'title'             => 'TEST ORDER PURE',
            'motif_id'          => 1,
            'metode'            => 'pure',
            'dp'                => 0,
            'harga_jual'        => 1000000,
            'barang_jadi_id'    => null,
            'nama_customer'     => 'TEST CUSTOMER 1',
            'alamat'            => 'TEST',
            'no_telp'           => '082114578976',
            'order_from_id'     => 2,
            'status'            => 'sales order',
            'notes'             => null,
            'sub_molding_id'    => null,
            'cost_molding_pure' => null,
            'created_by'        => 1,
            'updated_by'        => 1,
        ]);
        TrackingLog::create([
            'sales_order_id' => 1,
            'status'         => 'sales order',
            'created_at'     => $now,
            'updated_at'     => $now,
            'created_by'     => 1,
            'updated_by'     => 1,
        ]);

        SalesOrder::create([
            'code_order'        => $dt . '0002',
            'title'             => 'TEST ORDER SKINNING',
            'motif_id'          => 3,
            'metode'            => 'skinning',
            'dp'                => 0,
            'harga_jual'        => 1000000,
            'barang_jadi_id'    => null,
            'nama_customer'     => 'TEST CUSTOMER 2',
            'alamat'            => 'TEST',
            'no_telp'           => '082114578976',
            'order_from_id'     => 1,
            'status'            => 'sales order',
            'notes'             => null,
            'sub_molding_id'    => null,
            'cost_molding_pure' => null,
            'created_by'        => 1,
            'updated_by'        => 1,
        ]);
        SalesOrderSeq::create([
            'seq'        => 2,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        TrackingLog::create([
            'sales_order_id' => 2,
            'status'         => 'sales order',
            'created_at'     => $now,
            'updated_at'     => $now,
            'created_by'     => 1,
            'updated_by'     => 1,
        ]);
    }
}
