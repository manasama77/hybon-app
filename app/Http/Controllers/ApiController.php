<?php

namespace App\Http\Controllers;

use App\Models\StockMonitor;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function get_materials()
    {
        $data = StockMonitor::select([
            'stock_monitors.id',
            'stock_monitors.kode_barang',
            'stock_monitors.panjang',
            'stock_monitors.lebar',
            'stock_monitors.qty',
            'master_barangs.satuan',
            'stock_monitors.tipe_stock',
        ])
            ->leftJoin('master_barangs', 'master_barangs.id', '=', 'stock_monitors.master_barang_id')
            ->where('stock_monitors.panjang', '!=', 0)
            ->where('stock_monitors.lebar', '!=', 0)
            ->orWhere('stock_monitors.qty', '!=', 0)
            ->orderBy('stock_monitors.kode_barang', 'asc')
            ->get();
        return response()->json(['success' => true, 'data' => $data, 'message' => "success"]);
    }
}
