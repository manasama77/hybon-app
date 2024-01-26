<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Stock;
use App\Models\StockSeq;
use App\Models\MasterBarang;
use App\Models\StockMonitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StockInController extends Controller
{
    public function index()
    {
        $page_title = "Stock Masuk";

        $datas = Stock::with([
            'stock_monitor.master_barang',
            'stock_monitor.master_barang.tipe_barang',
        ])->where('status', 'in')->latest()->get();

        $data = [
            'page_title' => $page_title,
            'datas'      => $datas,
        ];

        return view('pages.warehouse.stock-in.index', $data);
    }

    public function create()
    {
        $page_title = "Tambah Data Stock Masuk";

        $master_barangs = MasterBarang::orderBy('nama_barang', 'asc')->get();

        $data = [
            'page_title'     => $page_title,
            'master_barangs' => $master_barangs,
        ];

        return view('pages.warehouse.stock-in.form', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'master_barang_id' => ['required', 'exists:master_barangs,id'],
            'panjang'          => ['nullable', 'min:1'],
            'lebar'            => ['nullable', 'min:1'],
            'qty'              => ['nullable', 'min:1'],
        ]);

        try {
            DB::beginTransaction();

            $master_barang = MasterBarang::find($request->master_barang_id);

            if ($master_barang->tipe_stock == 'satuan') {
                $check_stock = StockMonitor::where('master_barang_id', $request->master_barang_id)->first();
                if ($check_stock) {
                    $stock_monitor_id = $check_stock->id;
                    $kode_barang      = $check_stock->kode_barang;
                    StockMonitor::find($stock_monitor_id)->increment('qty', $request->qty);
                } else {
                    $kode_barang   = $this->generate_kode_barang($request->master_barang_id, $master_barang->tipe_stock, $master_barang->kode_barang);

                    $exec                   = new StockMonitor();
                    $exec->kode_barang      = $kode_barang;
                    $exec->master_barang_id = $request->master_barang_id;
                    $exec->tipe_stock       = $master_barang->tipe_stock;
                    $exec->panjang          = "0";
                    $exec->lebar            = "0";
                    $exec->qty              = $request->qty;
                    $exec->created_by       = auth()->user()->id;
                    $exec->updated_by       = auth()->user()->id;
                    $exec->save();
                    $stock_monitor_id = $exec->id;
                }

                $data = [
                    'kode_barang'      => $kode_barang,
                    'stock_monitor_id' => $stock_monitor_id,
                    'tipe_stock'       => $master_barang->tipe_stock,
                    'panjang'          => 0,
                    'lebar'            => 0,
                    'qty'              => $request->qty ?? 0,
                    'status'           => 'in',
                    'created_by'       => Auth::user()->id,
                    'updated_by'       => Auth::user()->id,
                ];
                Stock::create($data);
            } else {
                $kode_barang   = $this->generate_kode_barang($request->master_barang_id, $master_barang->tipe_stock, $master_barang->kode_barang);

                $exec                   = new StockMonitor();
                $exec->kode_barang      = $kode_barang;
                $exec->master_barang_id = $request->master_barang_id;
                $exec->tipe_stock       = $master_barang->tipe_stock;
                $exec->panjang          = $request->panjang;
                $exec->lebar            = $request->lebar;
                $exec->qty              = 0;
                $exec->created_by       = auth()->user()->id;
                $exec->updated_by       = auth()->user()->id;
                $exec->save();
                $stock_monitor_id = $exec->id;

                $data = [
                    'kode_barang'      => $kode_barang,
                    'stock_monitor_id' => $stock_monitor_id,
                    'tipe_stock'       => $master_barang->tipe_stock,
                    'panjang'          => $request->panjang ?? 0,
                    'lebar'            => $request->lebar ?? 0,
                    'qty'              => $request->qty ?? 0,
                    'status'           => 'in',
                    'created_by'       => Auth::user()->id,
                    'updated_by'       => Auth::user()->id,
                ];
                Stock::create($data);
            }

            DB::commit();

            return redirect()->route('warehouse.stock-in')->with('success', 'Data created successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function destroy($id)
    {
        $data             = Stock::find($id);
        if ($data->tipe_stock == 'satuan') {
            $data->stock_monitor()->decrement('qty', $data->qty);
        } else {
            $data->stock_monitor()->delete();
        }
        $data->deleted_by = auth()->user()->id;
        $data->save();
        $data->delete();

        return response()->json(['success' => true]);
    }

    protected function generate_kode_barang($master_barang_id, $tipe_stock, $kode_barang)
    {
        $now = Carbon::now();

        if ($tipe_stock == "satuan") {
            $kode_barang = $kode_barang . "-" . $now->format('Ymd');
        } else {
            $last_seq = StockMonitor::where('master_barang_id', $master_barang_id)
                ->where('tipe_stock', 'lembar')
                ->whereDate('created_at', $now)
                ->count();
            $last_seq++;
            $kode_barang = $kode_barang . "-" . $now->format('Ymd') . "-" . $last_seq . "-0";
        }
        return $kode_barang;
    }
}
