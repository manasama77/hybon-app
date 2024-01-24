<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Stock;
use App\Models\SalesOrder;
use Illuminate\Http\Request;
use App\Models\ManufactureMaterial;

class Finishing2Controller extends Controller
{
    public function index()
    {
        $page_title = "Finishing 2";

        $datas = SalesOrder::with([
            'motif',
            'barang_jadi',
            'order_from',
            'create_name',
        ])
            ->where('status', 'finishing 2')
            ->latest()
            ->get();

        $stocks = Stock::select([
            'stocks.id',
            'stocks.kode_barang',
            'stocks.qty',
            'master_barangs.satuan',
        ])
            ->leftJoin('master_barangs', 'master_barangs.id', '=', 'stocks.master_barang_id')
            ->where('stocks.qty', '!=', 0)
            ->where('stocks.tipe_stock', '=', 'satuan')
            ->orderBy('stocks.kode_barang', 'asc')
            ->get();

        $data = [
            'page_title' => $page_title,
            'datas'      => $datas,
            'stocks'     => $stocks,
        ];

        return view('pages.finishing.phase-2.index', $data);
    }

    public function show_material($sales_order_id)
    {
        try {
            $data = ManufactureMaterial::with([
                'stock',
                'stock.master_barang',
            ])
                ->where('sales_order_id', $sales_order_id)
                ->where('phase_seq', 'finishing 2')
                ->orderBy('created_at', 'desc')
                ->get();
            return response()->json(['success' => true, 'data' => $data, 'message' => "success"]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'data' => [], 'message' => $e->getMessage()]);
        }
    }

    public function store_material(Request $request)
    {
        try {
            $sales_order_id = $request->sales_order_id;
            $stock_id       = $request->stock_id;
            $qty            = $request->qty;

            $sales_order        = SalesOrder::find($sales_order_id);
            $revisi_finishing_2 = $sales_order->revisi_finishing_2;

            $stock_check      = Stock::with('master_barang')->find($stock_id);
            $stock_qty        = $stock_check->qty;
            $stock_harga_jual = $stock_check->master_barang->harga_jual;

            if ($qty > $stock_qty) {
                throw new Exception("Request $qty > Tersedia $stock_qty. QTY Tidak Mencukupi");
            }

            $notes = "New";

            if ($revisi_finishing_2 > 0) {
                $notes = "Revisi $revisi_finishing_2";
            }

            $exec                 = new ManufactureMaterial();
            $exec->sales_order_id = $sales_order_id;
            $exec->stock_id       = $stock_id;
            $exec->qty            = $qty;
            $exec->price          = $stock_harga_jual * $qty;
            $exec->notes          = $notes;
            $exec->phase_seq      = "finishing 2";
            $exec->revisi_seq     = $revisi_finishing_2;
            $exec->created_by = auth()->user()->id;
            $exec->updated_by = auth()->user()->id;

            $exec->stock->decrement('qty', $qty);

            $exec->save();

            return response()->json(['success' => true, 'message' => "success"]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function destroy_material(Request $request)
    {
        try {
            $id               = $request->id;
            $data             = ManufactureMaterial::find($id);
            $data->deleted_by = auth()->user()->id;

            //return stock
            $data->stock->increment('qty', $data->qty);

            $data->save();
            $data->delete();

            return response()->json(['success' => true, 'data' => $data, 'message' => "Data Terhapus"]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'data' => [], 'message' => $e->getMessage()]);
        }
    }

    public function update($sales_order_id, Request $request)
    {
        try {
            $data = SalesOrder::find($sales_order_id);

            // upload photo
            $photo = $request->file('photo');

            if (!$photo && $data->photo_finishing_2 == null) {
                throw new Exception('Photo finishing 2 Belum Diupload');
            }

            if ($photo) {
                $photoName = $data->id . '-finishing-2' . '.' . $photo->getClientOriginalExtension();
                $photo->move(public_path('img/finishing'), $photoName);
                $data->photo_finishing_2 = $photoName;
            }

            $data->title = $request->title;
            $data->dp    = $request->dp;
            $data->increment('revisi_finishing_2');

            $data->updated_by = auth()->user()->id;
            $data->save();
            return response()->json(['success' => true, 'data' => $data, 'message' => "success"]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'data' => [], 'message' => $e->getMessage()]);
        }
    }
}
