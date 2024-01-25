<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Stock;
use App\Models\SalesOrder;
use App\Models\StockMonitor;
use Illuminate\Http\Request;
use App\Models\ManufactureMaterial;

class ManufacturingCuttingController extends Controller
{
    public function index()
    {
        $page_title = "Manufacturing Cutting";

        $datas = SalesOrder::with([
            'motif',
            'barang_jadi',
            'order_from',
            'create_name',
        ])
            ->where('status', 'manufacturing cutting')
            ->latest()
            ->get();

        $stocks = StockMonitor::select([
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

        $data = [
            'page_title' => $page_title,
            'datas'      => $datas,
            'stocks'     => $stocks,
        ];

        return view('pages.manufacturing.cutting.index', $data);
    }

    public function show_material($sales_order_id)
    {
        try {
            $data = ManufactureMaterial::with([
                'stock',
                'stock.master_barang',
            ])
                ->where('sales_order_id', $sales_order_id)
                ->where('phase_seq', 'cutting')
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

            $sales_order                  = SalesOrder::find($sales_order_id);
            $revisi_manufacturing_cutting = $sales_order->revisi_manufacturing_cutting;

            $stock_check      = Stock::with('master_barang')->find($stock_id);
            $stock_qty        = $stock_check->qty;
            $stock_harga_jual = $stock_check->master_barang->harga_jual;

            if ($qty > $stock_qty) {
                throw new Exception("Request $qty > Tersedia $stock_qty. QTY Tidak Mencukupi");
            }

            $notes = "New";

            if ($revisi_manufacturing_cutting > 0) {
                $notes = "Revisi $revisi_manufacturing_cutting";
            }

            $exec                 = new ManufactureMaterial();
            $exec->sales_order_id = $sales_order_id;
            $exec->stock_id       = $stock_id;
            $exec->qty            = $qty;
            $exec->price          = $stock_harga_jual * $qty;
            $exec->notes          = $notes;
            $exec->phase_seq      = 'cutting';
            $exec->revisi_seq     = $revisi_manufacturing_cutting;
            $exec->created_by     = auth()->user()->id;
            $exec->updated_by     = auth()->user()->id;

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

            if (!$photo && $data->photo_manufacturing_cutting == null) {
                throw new Exception('Photo manufacturing Cutting Belum Diupload');
            }

            if ($photo) {
                $photoName = $data->id . '-manufacturing-cutting' . '.' . $photo->getClientOriginalExtension();
                $photo->move(public_path('img/manufacturing'), $photoName);
                $data->photo_manufacturing_cutting = $photoName;
            }

            $data->dp    = $request->dp;
            $data->increment('revisi_manufacturing_cutting');

            $data->updated_by = auth()->user()->id;
            $data->save();
            return response()->json(['success' => true, 'data' => $data, 'message' => "success"]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'data' => [], 'message' => $e->getMessage()]);
        }
    }
}
