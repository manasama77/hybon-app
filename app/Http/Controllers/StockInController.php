<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Stock;
use App\Models\StockSeq;
use App\Models\MasterBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StockInController extends Controller
{
    public function index()
    {
        $page_title = "Stock Masuk";

        $datas = Stock::with([
            'master_barang',
            'master_barang.tipe_barang',
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
            'panjang'          => ['nullable'],
            'lebar'            => ['nullable'],
            'qty'              => ['nullable'],
        ]);

        try {
            DB::beginTransaction();

            $master_barang = MasterBarang::find($request->master_barang_id);
            $check_stock   = Stock::where('master_barang_id', $request->master_barang_id)->where('status', 'in')->first();

            if ($master_barang->tipe_barang == 'satuan' && $check_stock) {
                Stock::find($check_stock->id)->increment('qty');
            } else {
                $kode_barang   = $this->generate_kode_barang($request->master_barang_id, $master_barang->tipe_stock, $master_barang->kode_barang);

                $data = [
                    'kode_barang'      => $kode_barang,
                    'master_barang_id' => $request->master_barang_id,
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
        $data->deleted_by = Auth::user()->id;
        $data->delete();

        return response()->json(['success' => true]);
    }

    protected function generate_kode_barang($master_barang_id, $tipe_stock, $kode_barang)
    {
        $now = Carbon::now();

        if ($tipe_stock == "satuan") {
            $kode_barang = $kode_barang . "-" . $now->format('Ymd');
        } else {
            $last_seq = Stock::where('master_barang_id', $master_barang_id)->where('tipe_stock', 'lembar')->count();
            $last_seq++;
            $kode_barang = $kode_barang . "-" . $now->format('Ymd') . "-" . $last_seq;
        }
        return $kode_barang;
    }
}
