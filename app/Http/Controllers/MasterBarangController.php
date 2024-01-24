<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\TipeBarang;
use App\Models\MasterBarang;
use Illuminate\Http\Request;
use App\Models\MasterBarangSeq;
use App\Models\SalesOrder;
use App\Models\SalesOrderSeq;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MasterBarangController extends Controller
{
    public function index()
    {
        $page_title = "Master Barang";

        $datas = MasterBarang::with([
            'tipe_barang',
        ])->latest()->get();

        $data = [
            'page_title' => $page_title,
            'datas'      => $datas,
        ];

        return view('pages.warehouse.master-barang.index', $data);
    }

    public function show($id)
    {
        $master_barang = MasterBarang::with('tipe_barang')->find($id);

        return response()->json($master_barang);
    }

    public function create()
    {
        $page_title = "Tambah Data Master Barang";

        $tipe_barangs = TipeBarang::orderBy('name', 'asc')->get();

        $data = [
            'page_title'   => $page_title,
            'tipe_barangs' => $tipe_barangs,
        ];

        return view('pages.warehouse.master-barang.form', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang'    => ['required', 'max:255', 'string'],
            'tipe_barang_id' => ['required', 'string', 'exists:tipe_barangs,id'],
            'nama_vendor'    => ['required', 'max:255', 'string'],
            'tipe_stock'     => ['required', 'in:satuan,lembar'],
            'satuan'         => ['required', 'max:50', 'string'],
            'harga_jual'     => ['required'],
        ]);

        try {
            DB::beginTransaction();

            $kode_barang = $this->generate_kode_barang($request->nama_barang);

            $data = [
                'kode_barang'    => $kode_barang,
                'nama_barang'    => $request->nama_barang,
                'tipe_barang_id' => $request->tipe_barang_id,
                'nama_vendor'    => $request->nama_vendor,
                'tipe_stock'     => $request->tipe_stock,
                'satuan'         => $request->satuan,
                'harga_jual'     => $request->harga_jual,
                'created_by'     => Auth::user()->id,
                'updated_by'     => Auth::user()->id,
            ];

            MasterBarang::create($data);

            DB::commit();

            return redirect()->route('warehouse.master-barang')->with('success', 'Data created successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function edit($id)
    {
        $page_title = "Edit Data Master Barang";

        $datas        = MasterBarang::find($id);
        $tipe_barangs = TipeBarang::orderBy('name', 'asc')->get();

        $data = [
            'page_title'   => $page_title,
            'datas'        => $datas,
            'tipe_barangs' => $tipe_barangs,
        ];

        return view('pages.warehouse.master-barang.form_edit', $data);
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'nama_barang'    => ['required', 'max:255', 'string'],
                'tipe_barang_id' => ['required', 'string', 'exists:tipe_barangs,id'],
                'nama_vendor'    => ['required', 'max:255', 'string'],
                'tipe_stock'     => ['required',  'in:satuan,lembar'],
                'satuan'         => ['required', 'max:50', 'string'],
                'harga_jual'     => ['required'],
            ]);

            $motif                 = MasterBarang::find($id);
            $motif->nama_barang    = $request->nama_barang;
            $motif->tipe_barang_id = $request->tipe_barang_id;
            $motif->nama_vendor    = $request->nama_vendor;
            $motif->tipe_stock     = $request->tipe_stock;
            $motif->satuan         = $request->satuan;
            $motif->harga_jual     = $request->harga_jual;
            $motif->save();

            DB::commit();

            return redirect()->route('warehouse.master-barang')->with('success', 'Data updated successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function destroy($id)
    {
        $motif             = MasterBarang::find($id);
        $motif->deleted_by = Auth::user()->id;
        $motif->delete();

        return response()->json(['success' => true]);
    }

    protected function generate_kode_barang($nama_barang)
    {
        // $last_data = MasterBarangSeq::latest()->first();

        // if (!$last_data) {
        //     $last_seq = 1;
        // } else {
        //     $last_seq = $last_data->last_seq + 1;
        // }

        // MasterBarangSeq::create(['seq' => $last_seq]);

        // php get first 4 charachter
        $prefix = substr($nama_barang, 0, 4);

        // if ($last_seq < 10) {
        //     return $prefix . '000' . $last_seq;
        // } elseif ($last_seq < 100) {
        //     return $prefix . '00' . $last_seq;
        // } elseif ($last_seq < 1000) {
        //     return $prefix . '0' . $last_seq;
        // } else {
        //     return $prefix . $last_seq;
        // }
        return $prefix;
    }
}
