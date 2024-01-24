<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Stock;
use App\Models\SalesOrder;
use Illuminate\Http\Request;

class RfsController extends Controller
{
    public function index()
    {
        $page_title = "RFS Pending";

        $datas = SalesOrder::with([
            'motif',
            'barang_jadi',
            'order_from',
            'create_name',
        ])
            ->where('status', 'rfs')
            ->where('is_lunas', false)
            ->latest()
            ->get();

        $data = [
            'page_title' => $page_title,
            'datas'      => $datas,
        ];

        return view('pages.rfs.index', $data);
    }

    public function update($sales_order_id, Request $request)
    {
        try {
            $data = SalesOrder::find($sales_order_id);
            if (!$data) {
                throw new Exception("data not found");
            }

            $harga_jual = $data->harga_jual;

            if ($request->dp > $harga_jual) {
                throw new Exception("DP melebihi Harga Jual");
            }

            $data->dp       = $request->dp;
            $data->is_lunas = true;

            $data->updated_by = auth()->user()->id;
            $data->save();
            return response()->json(['success' => true, 'data' => $data, 'message' => "success"]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'data' => [], 'message' => $e->getMessage()]);
        }
    }
}
