<?php

namespace App\Http\Controllers;

use App\Models\MetodeMolding;
use App\Models\SalesOrder;
use App\Models\Stock;
use App\Models\StockMonitor;
use Illuminate\Http\Request;

class ProductDesignController extends Controller
{
    public function index()
    {
        $page_title = "Product Design";

        $datas = SalesOrder::with([
            'motif',
            'barang_jadi',
            'order_from',
            'create_name',
        ])->where('status', 'product design')->latest()->get();

        $metode_moldings = MetodeMolding::orderBy('name', 'asc')->get();
        $stocks = StockMonitor::select([
            'stock_monitors.id',
            'stock_monitors.kode_barang',
            'stock_monitors.panjang',
            'stock_monitors.lebar',
            'master_barangs.satuan',
        ])
            ->leftJoin('master_barangs', 'master_barangs.id', '=', 'stock_monitors.master_barang_id')
            ->where('stock_monitors.panjang', '!=', 0)
            ->where('stock_monitors.lebar', '!=', 0)
            ->where('stock_monitors.tipe_stock', '=', 'lembar')
            ->orderBy('stock_monitors.kode_barang', 'asc')
            ->get();

        $data = [
            'page_title'      => $page_title,
            'datas'           => $datas,
            'metode_moldings' => $metode_moldings,
            'stocks'          => $stocks,
        ];

        return view('pages.product-design.index', $data);
    }
}
