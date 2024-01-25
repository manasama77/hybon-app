<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\StockMonitor;
use Illuminate\Http\Request;

class StockMonitorController extends Controller
{
    public function index()
    {
        $page_title = "Stock Monitor";

        $datas = StockMonitor::with([
            'master_barang',
            'master_barang.tipe_barang',
        ])->latest()->get();

        $data = [
            'page_title' => $page_title,
            'datas'      => $datas,
        ];

        return view('pages.warehouse.stock-monitor.index', $data);
    }
}
