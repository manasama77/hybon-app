<?php

namespace App\Http\Controllers;

use App\Models\MetodeMolding;
use App\Models\SalesOrder;
use App\Models\Stock;
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
        $stocks = Stock::select([
            'stocks.id',
            'stocks.kode_barang',
            'stocks.panjang',
            'stocks.lebar',
            'master_barangs.satuan',
        ])
            ->leftJoin('master_barangs', 'master_barangs.id', '=', 'stocks.master_barang_id')
            ->where('stocks.panjang', '!=', 0)
            ->where('stocks.lebar', '!=', 0)
            ->where('stocks.tipe_stock', '=', 'lembar')
            ->orderBy('stocks.kode_barang', 'asc')
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
