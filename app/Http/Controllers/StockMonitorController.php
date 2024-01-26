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

    public function edit($id)
    {
        $page_title = "Edit Harga Jual";

        $datas = StockMonitor::with('master_barang')->find($id);

        $data = [
            'page_title' => $page_title,
            'data'       => $datas,
        ];

        return view('pages.warehouse.stock-monitor.form', $data);
    }

    public function update($id, Request $request)
    {
        $exec             = StockMonitor::find($id);
        $exec->harga_jual = $request->harga_jual;
        $exec->save();

        $exec_s = Stock::where('stock_monitor_id', $id)->where('status', 'in')->first();

        $up             = Stock::find($exec_s->id);
        $up->harga_jual = $request->harga_jual;
        $up->save();

        return redirect()->route('warehouse.stock-monitor')->with('success', 'Data created successfully.');
    }
}
