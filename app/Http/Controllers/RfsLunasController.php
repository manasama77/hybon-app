<?php

namespace App\Http\Controllers;

use App\Models\ManufactureMaterial;
use App\Models\SalesOrder;
use Illuminate\Http\Request;

class RfsLunasController extends Controller
{
    public function index()
    {
        $page_title = "RFS Lunas";

        $datas = SalesOrder::with([
            'motif',
            'barang_jadi',
            'order_from',
            'create_name',
        ])
            ->where('status', 'rfs')
            ->where('is_lunas', true)
            ->latest()
            ->get();

        $data = [
            'page_title' => $page_title,
            'datas'      => $datas,
        ];

        return view('pages.rfs-lunas.index', $data);
    }
}
