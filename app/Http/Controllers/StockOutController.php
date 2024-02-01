<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;

class StockOutController extends Controller
{
    public function index()
    {
        $page_title = "Stock Keluar";

        $datas = Stock::with([
            'stock_monitor.master_barang',
            'stock_monitor.master_barang.tipe_barang',
            'sales_order',
            'created_name',
        ])->where('stocks.status', 'out')->get();

        $data = [
            'page_title' => $page_title,
            'datas'      => $datas,
        ];

        return view('pages.warehouse.stock-out.index', $data);
    }
}
