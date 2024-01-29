<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Stock;
use App\Models\SalesOrder;
use App\Models\StockMonitor;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
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

        $data = [
            'page_title' => $page_title,
            'datas'      => $datas,
        ];

        return view('pages.finishing.phase-2.index', $data);
    }

    public function show_material($sales_order_id)
    {
        try {
            $data = ManufactureMaterial::with([
                'stock_monitor',
                'stock_monitor.master_barang',
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
            DB::beginTransaction();
            $phase = "finishing 2"; // edit ini

            $sales_order_id   = $request->sales_order_id;
            $metode           = $request->metode;
            $stock_monitor_id = $request->stock_id;
            $qty              = $request->qty * 1;
            $panjang          = $request->panjang * 1;
            $lebar            = $request->lebar * 1;

            $sales_order = SalesOrder::find($sales_order_id);
            if (!$sales_order) {
                throw new Exception('Order Not Found');
            }

            $rev = $sales_order->revisi_finishing_2; // edit ini

            $stock_check = StockMonitor::with('master_barang')->find($stock_monitor_id);
            if (!$stock_check) {
                throw new Exception('Stock Not Found');
            }

            $kode_barang       = $stock_check->kode_barang;
            $master_barang_id  = $stock_check->master_barang_id;
            $stock_qty         = $stock_check->qty;
            $stock_panjang     = $stock_check->panjang;
            $stock_lebar       = $stock_check->lebar;
            $stock_harga_jual  = $stock_check->harga_jual;
            $harga_jual_potong = 0;

            if ($metode == "lembar") {
                if ($panjang > $stock_panjang) {
                    throw new Exception("Request $panjang > Tersedia $stock_panjang. Dimensi Tidak Mencukupi");
                }

                if ($lebar > $stock_lebar) {
                    throw new Exception("Request $lebar > Tersedia $stock_lebar. Dimensi Tidak Mencukupi");
                }

                $sisa_panjang = $stock_panjang - $panjang;
                $sisa_lebar   = $stock_lebar - $lebar;

                if ($sisa_panjang == 0 && $sisa_lebar == 0) {
                    $harga_jual_potong = $stock_harga_jual;

                    // sisa 0 bidang
                    $x                   = new Stock();
                    $x->kode_barang      = $kode_barang;
                    $x->stock_monitor_id = $stock_monitor_id;
                    $x->tipe_stock       = $metode;
                    $x->panjang          = $panjang;
                    $x->lebar            = $lebar;
                    $x->qty              = 0;
                    $x->harga_jual       = $harga_jual_potong;
                    $x->status           = 'out';
                    $x->sales_order_id   = $sales_order_id;
                    $x->created_at       = Carbon::now();
                    $x->updated_at       = Carbon::now();
                    $x->created_by       = auth()->user()->id;
                    $x->updated_by       = auth()->user()->id;
                    $x->save();
                } elseif ($sisa_panjang == 0 || $sisa_lebar == 0) {
                    // sisa 1 bidang

                    // penentuan harga per cm
                    $luas_ruang_total = $stock_panjang * $stock_lebar;
                    $harga_dasar      = $stock_harga_jual / $luas_ruang_total;

                    // harga jual potong
                    $luas_potong  = $panjang * $lebar;
                    $harga_potong = $luas_potong * $harga_dasar;

                    $harga_jual_potong = $harga_potong;

                    // bidang potong
                    $x_potong                   = new Stock();
                    $x_potong->kode_barang      = $kode_barang;
                    $x_potong->stock_monitor_id = $stock_monitor_id;
                    $x_potong->tipe_stock       = $metode;
                    $x_potong->panjang          = $panjang;
                    $x_potong->lebar            = $lebar;
                    $x_potong->qty              = 0;
                    $x_potong->harga_jual       = $harga_potong;
                    $x_potong->status           = 'out';
                    $x_potong->sales_order_id   = $sales_order_id;
                    $x_potong->created_at       = Carbon::now();
                    $x_potong->updated_at       = Carbon::now();
                    $x_potong->created_by       = auth()->user()->id;
                    $x_potong->updated_by       = auth()->user()->id;
                    $x_potong->save();

                    // bidang sisa 1
                    $arr_kode_barang = explode('-', $kode_barang);
                    $prefix          = $arr_kode_barang[0];
                    $dt              = $arr_kode_barang[1];
                    $seq             = $arr_kode_barang[2];
                    $ord             = $arr_kode_barang[3] + 1;

                    $new_kode_barang = $prefix . '-' . $dt . '-' . $seq . '-' . $ord;

                    $new_panjang = $sisa_panjang;
                    $new_lebar   = $sisa_lebar;

                    // throw new Exception($new_panjang . " " . $new_lebar);

                    if ($sisa_panjang == 0) {
                        $new_panjang = $stock_panjang;
                    } else {
                        $new_lebar = $stock_lebar;
                    }

                    // harga jual sisa 1
                    $luas_sisa_1  = $new_panjang * $new_lebar;
                    $harga_sisa_1 = $luas_sisa_1 * $harga_dasar;

                    $x_new_monitor_1                   = new StockMonitor();
                    $x_new_monitor_1->kode_barang      = $new_kode_barang;
                    $x_new_monitor_1->master_barang_id = $master_barang_id;
                    $x_new_monitor_1->tipe_stock       = $metode;
                    $x_new_monitor_1->panjang          = $new_panjang;
                    $x_new_monitor_1->lebar            = $new_lebar;
                    $x_new_monitor_1->qty              = 0;
                    $x_new_monitor_1->harga_jual       = $harga_sisa_1;
                    $x_new_monitor_1->created_at       = Carbon::now();
                    $x_new_monitor_1->updated_at       = Carbon::now();
                    $x_new_monitor_1->created_by       = auth()->user()->id;
                    $x_new_monitor_1->updated_by       = auth()->user()->id;
                    $x_new_monitor_1->save();
                    $x_id_1 = $x_new_monitor_1->id;

                    $x_new_stock_1                   = new Stock();
                    $x_new_stock_1->kode_barang      = $new_kode_barang;
                    $x_new_stock_1->stock_monitor_id = $x_id_1;
                    $x_new_stock_1->tipe_stock       = $metode;
                    $x_new_stock_1->panjang          = $new_panjang;
                    $x_new_stock_1->lebar            = $new_lebar;
                    $x_new_stock_1->qty              = 0;
                    $x_new_stock_1->harga_jual       = $harga_sisa_1;
                    $x_new_stock_1->status           = 'in';
                    $x_new_stock_1->created_at       = Carbon::now();
                    $x_new_stock_1->updated_at       = Carbon::now();
                    $x_new_stock_1->created_by       = auth()->user()->id;
                    $x_new_stock_1->updated_by       = auth()->user()->id;
                    $x_new_stock_1->save();
                } else {
                    // sisa 2 bidang

                    // penentuan harga per cm
                    $luas_ruang_total = $stock_panjang * $stock_lebar;
                    $harga_dasar      = $stock_harga_jual / $luas_ruang_total;

                    // harga jual potong
                    $luas_potong  = $panjang * $lebar;
                    $harga_potong = $luas_potong * $harga_dasar;

                    $harga_jual_potong = $harga_potong;

                    // bidang potong
                    $x_potong                   = new Stock();
                    $x_potong->kode_barang      = $kode_barang;
                    $x_potong->stock_monitor_id = $stock_monitor_id;
                    $x_potong->tipe_stock       = $metode;
                    $x_potong->panjang          = $panjang;
                    $x_potong->lebar            = $lebar;
                    $x_potong->qty              = 0;
                    $x_potong->harga_jual       = $harga_potong;
                    $x_potong->status           = 'out';
                    $x_potong->sales_order_id   = $sales_order_id;
                    $x_potong->created_at       = Carbon::now();
                    $x_potong->updated_at       = Carbon::now();
                    $x_potong->created_by       = auth()->user()->id;
                    $x_potong->updated_by       = auth()->user()->id;
                    $x_potong->save();

                    // bidang sisa 1
                    $arr_kode_barang = explode('-', $kode_barang);
                    $prefix          = $arr_kode_barang[0];
                    $dt              = $arr_kode_barang[1];
                    $seq             = $arr_kode_barang[2];
                    $ord             = $arr_kode_barang[3] + 1;
                    $new_kode_barang = $prefix . '-' . $dt . '-' . $seq . '-' . $ord;

                    // harga jual sisa 1
                    $luas_sisa_1  = $sisa_panjang * $lebar;
                    $harga_sisa_1 = $luas_sisa_1 * $harga_dasar;

                    $x_new_monitor_1                   = new StockMonitor();
                    $x_new_monitor_1->kode_barang      = $new_kode_barang;
                    $x_new_monitor_1->master_barang_id = $master_barang_id;
                    $x_new_monitor_1->tipe_stock       = $metode;
                    $x_new_monitor_1->panjang          = $sisa_panjang;
                    $x_new_monitor_1->lebar            = $lebar;
                    $x_new_monitor_1->qty              = 0;
                    $x_new_monitor_1->harga_jual       = $harga_sisa_1;
                    $x_new_monitor_1->created_at       = Carbon::now();
                    $x_new_monitor_1->updated_at       = Carbon::now();
                    $x_new_monitor_1->created_by       = auth()->user()->id;
                    $x_new_monitor_1->updated_by       = auth()->user()->id;
                    $x_new_monitor_1->save();
                    $x_id_1 = $x_new_monitor_1->id;

                    $x_new_stock_1                   = new Stock();
                    $x_new_stock_1->kode_barang      = $new_kode_barang;
                    $x_new_stock_1->stock_monitor_id = $x_id_1;
                    $x_new_stock_1->tipe_stock       = $metode;
                    $x_new_stock_1->panjang          = $sisa_panjang;
                    $x_new_stock_1->lebar            = $lebar;
                    $x_new_stock_1->qty              = 0;
                    $x_new_stock_1->harga_jual       = $harga_sisa_1;
                    $x_new_stock_1->status           = 'in';
                    $x_new_stock_1->created_at       = Carbon::now();
                    $x_new_stock_1->updated_at       = Carbon::now();
                    $x_new_stock_1->created_by       = auth()->user()->id;
                    $x_new_stock_1->updated_by       = auth()->user()->id;
                    $x_new_stock_1->save();

                    // bidang sisa 2
                    $arr_kode_barang = explode('-', $new_kode_barang);
                    $prefix          = $arr_kode_barang[0];
                    $dt              = $arr_kode_barang[1];
                    $seq             = $arr_kode_barang[2];
                    $ord             = $arr_kode_barang[3] + 1;
                    $new_kode_barang = $prefix . '-' . $dt . '-' . $seq . '-' . $ord;

                    // harga jual sisa 2
                    $luas_sisa_2  = $stock_panjang * $sisa_lebar;
                    $harga_sisa_2 = $luas_sisa_2 * $harga_dasar;

                    $x_new_monitor_2                   = new StockMonitor();
                    $x_new_monitor_2->kode_barang      = $new_kode_barang;
                    $x_new_monitor_2->master_barang_id = $master_barang_id;
                    $x_new_monitor_2->tipe_stock       = $metode;
                    $x_new_monitor_2->panjang          = $stock_panjang;
                    $x_new_monitor_2->lebar            = $sisa_lebar;
                    $x_new_monitor_2->qty              = 0;
                    $x_new_monitor_2->harga_jual       = $harga_sisa_2;
                    $x_new_monitor_2->created_at       = Carbon::now();
                    $x_new_monitor_2->updated_at       = Carbon::now();
                    $x_new_monitor_2->created_by       = auth()->user()->id;
                    $x_new_monitor_2->updated_by       = auth()->user()->id;
                    $x_new_monitor_2->save();
                    $x_id_2 = $x_new_monitor_2->id;

                    $x_new_stock_2                   = new Stock();
                    $x_new_stock_2->kode_barang      = $new_kode_barang;
                    $x_new_stock_2->stock_monitor_id = $x_id_2;
                    $x_new_stock_2->tipe_stock       = $metode;
                    $x_new_stock_2->panjang          = $stock_panjang;
                    $x_new_stock_2->lebar            = $sisa_lebar;
                    $x_new_stock_2->qty              = 0;
                    $x_new_stock_2->harga_jual       = $harga_sisa_2;
                    $x_new_stock_2->status           = 'in';
                    $x_new_stock_2->created_at       = Carbon::now();
                    $x_new_stock_2->updated_at       = Carbon::now();
                    $x_new_stock_2->created_by       = auth()->user()->id;
                    $x_new_stock_2->updated_by       = auth()->user()->id;
                    $x_new_stock_2->save();
                }

                $stock_check->panjang    = 0;
                $stock_check->lebar      = 0;
                $stock_check->qty        = 0;
                $stock_check->updated_by = auth()->user()->id;
                $stock_check->save();
            } else {
                if ($qty > $stock_qty) {
                    throw new Exception("Request $qty > Tersedia $stock_qty. QTY Tidak Mencukupi");
                }

                $harga_jual_potong = $stock_harga_jual * $qty;

                $x                   = new Stock();
                $x->kode_barang      = $kode_barang;
                $x->stock_monitor_id = $stock_monitor_id;
                $x->tipe_stock       = $metode;
                $x->panjang          = 0;
                $x->lebar            = 0;
                $x->qty              = $qty;
                $x->harga_jual       = $harga_jual_potong;
                $x->status           = 'out';
                $x->created_at       = Carbon::now();
                $x->updated_at       = Carbon::now();
                $x->created_by       = auth()->user()->id;
                $x->updated_by       = auth()->user()->id;
                $x->save();

                $stock_check->panjang    = 0;
                $stock_check->lebar      = 0;
                $stock_check->decrement('qty', $qty);
                $stock_check->updated_by = auth()->user()->id;
                $stock_check->save();
            }

            $notes = "New";

            if ($rev > 0) {
                $notes = "Revisi $rev";
            }

            $exec                   = new ManufactureMaterial();
            $exec->sales_order_id   = $sales_order_id;
            $exec->stock_monitor_id = $stock_monitor_id;
            $exec->qty              = $qty;
            $exec->panjang          = $panjang;
            $exec->lebar            = $lebar;
            $exec->price            = $harga_jual_potong;
            $exec->notes            = $notes;
            $exec->phase_seq        = $phase;
            $exec->revisi_seq       = $rev;
            $exec->created_by       = auth()->user()->id;
            $exec->updated_by       = auth()->user()->id;
            $exec->save();

            DB::commit();

            return response()->json(['success' => true, 'message' => "success"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
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

            $data->dp    = $request->dp;
            $data->increment('revisi_finishing_2');

            $data->updated_by = auth()->user()->id;
            $data->save();
            return response()->json(['success' => true, 'data' => $data, 'message' => "success"]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'data' => [], 'message' => $e->getMessage()]);
        }
    }

    protected function generate_kode_barang($master_barang_id, $tipe_stock, $kode_barang)
    {
        $now = Carbon::now();

        if ($tipe_stock == "satuan") {
            $kode_barang = $kode_barang . "-" . $now->format('Ymd');
        } else {
            $last_seq = StockMonitor::where('master_barang_id', $master_barang_id)->where('tipe_stock', 'lembar')->count();
            $last_seq++;
            $kode_barang = $kode_barang . "-" . $now->format('Ymd') . "-" . $last_seq;
        }
        return $kode_barang;
    }
}
