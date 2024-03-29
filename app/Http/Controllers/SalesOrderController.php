<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Motif;
use App\Models\Stock;
use App\Models\OrderFrom;
use App\Models\BarangJadi;
use App\Models\SalesOrder;
use App\Models\TrackingLog;
use App\Models\StockMonitor;
use Illuminate\Http\Request;
use App\Models\PureStatusLog;
use App\Models\SalesOrderSeq;
use Illuminate\Support\Facades\DB;
use App\Models\ManufactureMaterial;
use Illuminate\Support\Facades\Auth;

class SalesOrderController extends Controller
{
    public function index()
    {
        $page_title = "Sales Order";

        $datas = SalesOrder::with([
            'motif',
            'barang_jadi',
            'order_from',
            'create_name',
        ])->where('status', 'sales order')->latest()->get();

        $data = [
            'page_title' => $page_title,
            'datas'      => $datas,
        ];

        return view('pages.sales-order.index', $data);
    }

    public function show($id, $metode)
    {
        try {
            if ($metode == "pure") {
                $data = SalesOrder::with([
                    'motif',
                    'barang_jadi',
                    'order_from',
                    'create_name',
                    'sub_molding',
                    'sub_molding.metode_molding',
                ])->find($id);
            } else {
                $data = SalesOrder::with([
                    'motif',
                    'barang_jadi',
                    'order_from',
                    'create_name',
                    'stock_monitor',
                ])->find($id);
            }

            return response()->json(['success' => true, 'data' => $data, 'message' => "success"]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'data' => [], 'message' => $e->getMessage()]);
        }
    }

    public function show_for_manufacturing($id)
    {
        try {
            $data = SalesOrder::find($id);

            return response()->json(['success' => true, 'data' => $data, 'message' => "success"]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'data' => [], 'message' => $e->getMessage()]);
        }
    }

    public function show_manufacturing_log($id)
    {
        try {
            $data = ManufactureMaterial::select([
                'manufacture_materials.created_at',
                'stock_monitors.kode_barang',
                'manufacture_materials.metode',
                'manufacture_materials.panjang',
                'manufacture_materials.lebar',
                'manufacture_materials.qty',
                'master_barangs.satuan',
                'manufacture_materials.price',
                'manufacture_materials.phase_seq',
                'manufacture_materials.notes',
                'users.name as created_by',
            ])
                ->leftJoin('sales_orders', 'sales_orders.id', 'manufacture_materials.sales_order_id')
                ->leftJoin('stock_monitors', 'stock_monitors.id', 'manufacture_materials.stock_monitor_id')
                ->leftJoin('master_barangs', 'master_barangs.id', 'stock_monitors.master_barang_id')
                ->leftJoin('users', 'users.id', 'manufacture_materials.created_by')
                ->where('sales_orders.id', $id)
                ->orderBy('manufacture_materials.created_at', 'asc')
                ->get();

            return response()->json(['success' => true, 'data' => $data, 'message' => "success"]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'data' => [], 'message' => $e->getMessage()]);
        }
    }

    public function create()
    {
        $page_title = "Tambah Data Sales Order";

        $motifs       = Motif::orderBy('name', 'asc')->get();
        $barang_jadis = BarangJadi::orderBy('name', 'asc')->get();
        $order_froms  = OrderFrom::orderBy('name', 'asc')->get();

        $data = [
            'page_title'   => $page_title,
            'motifs'       => $motifs,
            'barang_jadis' => $barang_jadis,
            'order_froms'  => $order_froms,
        ];

        return view('pages.sales-order.form', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'          => ['required', 'max:255', 'string'],
            'motif_id'       => ['required', 'exists:motifs,id'],
            'metode'         => ['required', 'in:pure,skinning'],
            'barang_jadi_id' => ['nullable', 'exists:barang_jadis,id'],
            'dp'             => ['required'],
            'harga_jual'     => ['required'],
            'nama_customer'  => ['required', 'max:255'],
            'alamat'         => ['required', 'max:255'],
            'no_telp'        => ['required', 'max:20'],
            'order_from_id'  => ['required', 'exists:order_froms,id'],
        ]);

        try {
            DB::beginTransaction();

            $code_order = $this->generate_code_order();

            $data = [
                'code_order'     => $code_order,
                'title'          => $request->title,
                'motif_id'       => $request->motif_id,
                'metode'         => $request->metode,
                'dp'             => $request->dp,
                'harga_jual'     => $request->harga_jual,
                'barang_jadi_id' => $request->barang_jadi_id ?? null,
                'nama_customer'  => $request->nama_customer,
                'alamat'         => $request->alamat,
                'no_telp'        => $request->no_telp,
                'order_from_id'  => $request->order_from_id,
                'status'         => 'sales order',
                'created_by'     => Auth::user()->id,
                'updated_by'     => Auth::user()->id,
            ];

            $exec = SalesOrder::create($data);

            $log                 = new TrackingLog();
            $log->sales_order_id = $exec->id;
            $log->status         = "sales order";
            $log->created_by     = auth()->user()->id;
            $log->updated_by     = auth()->user()->id;
            $log->save();

            DB::commit();

            return redirect()->route('sales-order')->with('success', 'Data created successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    protected function generate_code_order()
    {
        $last_data = SalesOrderSeq::whereDate('created_at', Carbon::now())->first();

        if (!$last_data) {
            $last_seq = 1;
            SalesOrderSeq::create(['seq' => $last_seq]);
        } else {
            $last_seq = $last_data->seq + 1;
            SalesOrderSeq::where('id', $last_data->id)->update(['seq' => $last_seq]);
        }

        $last_seq = str_pad($last_seq, 4, "0", STR_PAD_LEFT);

        $now        = Carbon::now();
        $code_order = $now->format('Ymd') . $last_seq;

        return $code_order;
    }

    public function edit($id)
    {
        $page_title = "Edit Data Sales Order";

        $datas        = SalesOrder::find($id);
        $motifs       = Motif::orderBy('name', 'asc')->get();
        $barang_jadis = BarangJadi::orderBy('name', 'asc')->get();
        $order_froms  = OrderFrom::orderBy('name', 'asc')->get();

        $data = [
            'page_title'   => $page_title,
            'datas'        => $datas,
            'motifs'       => $motifs,
            'barang_jadis' => $barang_jadis,
            'order_froms'  => $order_froms,
        ];

        return view('pages.sales-order.form_edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'          => ['required', 'max:255', 'string'],
            'motif_id'       => ['required', 'exists:motifs,id'],
            'metode'         => ['required', 'in:pure,skinning'],
            'barang_jadi_id' => ['nullable', 'exists:barang_jadis,id'],
            'dp'             => ['required'],
            'harga_jual'     => ['required'],
            'nama_customer'  => ['required', 'max:255'],
            'alamat'         => ['required', 'max:255'],
            'no_telp'        => ['required', 'max:20'],
            'order_from_id'  => ['required', 'exists:order_froms,id'],
        ]);

        try {
            DB::beginTransaction();

            $data = [
                'title'          => $request->title,
                'motif_id'       => $request->motif_id,
                'metode'         => $request->metode,
                'dp'             => $request->dp,
                'harga_jual'     => $request->harga_jual,
                'barang_jadi_id' => $request->barang_jadi_id,
                'nama_customer'  => $request->nama_customer,
                'alamat'         => $request->alamat,
                'no_telp'        => $request->no_telp,
                'order_from_id'  => $request->order_from_id,
                'status'         => 'sales order',
                'updated_by'     => Auth::user()->id,
            ];

            SalesOrder::find($id)->update($data);

            DB::commit();

            return redirect()->route('sales-order')->with('success', 'Data updated successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function move_product_design($id)
    {
        try {
            $data             = SalesOrder::find($id);
            $data->status     = "product design";
            $data->updated_by = Auth::user()->id;
            $data->save();

            $log                 = new TrackingLog();
            $log->sales_order_id = $id;
            $log->status         = "product design";
            $log->created_by     = auth()->user()->id;
            $log->updated_by     = auth()->user()->id;
            $log->save();

            return response()->json(['success' => true, 'message' => 'Pindah data berhasil']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function move_product_manufacturing($id)
    {
        try {
            DB::beginTransaction();

            $data             = SalesOrder::find($id);
            $metode           = $data->metode;

            // for skinning
            $panjang_skinning = $data->panjang_skinning;
            $lebar_skinning   = $data->lebar_skinning;
            $stock_id         = $data->stock_monitor_id;

            // for pure
            $sub_molding_id        = $data->sub_molding_id;
            $cost_molding_pure     = $data->cost_molding_pure;
            $count_pure_status_log = PureStatusLog::where('sales_order_id', $id)->count();

            if ($metode == "pure") {
                if ($sub_molding_id == null) {
                    throw new Exception('Metode Molding & Sub Molding Belum Dipilih');
                }

                if ($cost_molding_pure == null) {
                    throw new Exception('Cost Molding Belum Diisi');
                }

                if ($count_pure_status_log == 0) {
                    throw new Exception('Status Pure Belum Diisi');
                }

                $data->status     = "manufacturing cutting";

                $log                 = new TrackingLog();
                $log->sales_order_id = $id;
                $log->status         = "manufacturing cutting";
                $log->created_by     = auth()->user()->id;
                $log->updated_by     = auth()->user()->id;
                $log->save();
            } else {
                if ($panjang_skinning == 0 || $lebar_skinning == 0) {
                    throw new Exception('Panjang dan lebar skinning belum terisi');
                }

                if ($stock_id == null) {
                    throw new Exception('Material Belum Dipilih');
                }

                $stock = StockMonitor::with('master_barang')->find($stock_id);
                // adam

                if (!$stock) {
                    throw new Exception("Material tidak ditemukan");
                }

                $master_barang_id = $stock->master_barang_id;
                $tipe_stock       = $stock->tipe_stock;
                $kode_barang      = $stock->kode_barang;
                $stock_panjang    = $stock->panjang;
                $stock_lebar      = $stock->lebar;
                $stock_harga_jual = $stock->harga_jual;

                ///
                if ($tipe_stock == "lembar") {
                    if ($panjang_skinning > $stock_panjang) {
                        throw new Exception("Request $panjang_skinning > Tersedia $stock_panjang. Dimensi Tidak Mencukupi");
                    }

                    if ($lebar_skinning > $stock_lebar) {
                        throw new Exception("Request $lebar_skinning > Tersedia $stock_lebar. Dimensi Tidak Mencukupi");
                    }

                    $sisa_panjang = $stock_panjang - $panjang_skinning;
                    $sisa_lebar   = $stock_lebar - $lebar_skinning;

                    if ($sisa_panjang == 0 && $sisa_lebar == 0) {
                        $harga_jual_potong = $stock_harga_jual;

                        // sisa 0 bidang
                        $x                   = new Stock();
                        $x->kode_barang      = $kode_barang;
                        $x->stock_monitor_id = $stock_id;
                        $x->tipe_stock       = $tipe_stock;
                        $x->panjang          = $panjang_skinning;
                        $x->lebar            = $lebar_skinning;
                        $x->qty              = 0;
                        $x->harga_jual       = $harga_jual_potong;
                        $x->status           = 'out';
                        $x->sales_order_id   = $id;
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
                        $luas_potong  = $panjang_skinning * $lebar_skinning;
                        $harga_potong = $luas_potong * $harga_dasar;

                        $harga_jual_potong = $harga_potong;

                        // bidang potong
                        $x_potong                   = new Stock();
                        $x_potong->kode_barang      = $kode_barang;
                        $x_potong->stock_monitor_id = $stock_id;
                        $x_potong->tipe_stock       = $tipe_stock;
                        $x_potong->panjang          = $panjang_skinning;
                        $x_potong->lebar            = $lebar_skinning;
                        $x_potong->qty              = 0;
                        $x_potong->harga_jual       = $harga_potong;
                        $x_potong->status           = 'out';
                        $x_potong->sales_order_id   = $id;
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
                        $x_new_monitor_1->tipe_stock       = $tipe_stock;
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
                        $x_new_stock_1->tipe_stock       = $tipe_stock;
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
                        $luas_potong  = $panjang_skinning * $lebar_skinning;
                        $harga_potong = $luas_potong * $harga_dasar;

                        $harga_jual_potong = $harga_potong;

                        // bidang potong
                        $x_potong                   = new Stock();
                        $x_potong->kode_barang      = $kode_barang;
                        $x_potong->stock_monitor_id = $stock_id;
                        $x_potong->tipe_stock       = $tipe_stock;
                        $x_potong->panjang          = $panjang_skinning;
                        $x_potong->lebar            = $lebar_skinning;
                        $x_potong->qty              = 0;
                        $x_potong->harga_jual       = $harga_potong;
                        $x_potong->status           = 'out';
                        $x_potong->sales_order_id   = $id;
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
                        $luas_sisa_1  = $sisa_panjang * $lebar_skinning;
                        $harga_sisa_1 = $luas_sisa_1 * $harga_dasar;

                        $x_new_monitor_1                   = new StockMonitor();
                        $x_new_monitor_1->kode_barang      = $new_kode_barang;
                        $x_new_monitor_1->master_barang_id = $master_barang_id;
                        $x_new_monitor_1->tipe_stock       = $tipe_stock;
                        $x_new_monitor_1->panjang          = $sisa_panjang;
                        $x_new_monitor_1->lebar            = $lebar_skinning;
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
                        $x_new_stock_1->tipe_stock       = $tipe_stock;
                        $x_new_stock_1->panjang          = $sisa_panjang;
                        $x_new_stock_1->lebar            = $lebar_skinning;
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
                        $x_new_monitor_2->tipe_stock       = $tipe_stock;
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
                        $x_new_stock_2->tipe_stock       = $tipe_stock;
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

                    $stock->panjang    = 0;
                    $stock->lebar      = 0;
                    $stock->qty        = 0;
                    $stock->updated_by = auth()->user()->id;
                    $stock->save();
                }
                ///

                $data->status = "manufacturing 1";

                $log                 = new TrackingLog();
                $log->sales_order_id = $id;
                $log->status         = "manufacturing 1";
                $log->created_by     = auth()->user()->id;
                $log->updated_by     = auth()->user()->id;
                $log->save();
            }

            $data->updated_by = Auth::user()->id;
            $data->save();

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Pindah data berhasil']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getLine() . " " . $e->getMessage()]);
        }
    }

    public function move_product_manufacturing_2($id)
    {
        try {
            $data   = SalesOrder::find($id);

            $photo = $data->photo_manufacturing_1;
            if ($photo == null) {
                throw new Exception('Photo manufacturing 1 Belum Diupload');
            }

            // $count_material = ManufactureMaterial::where('sales_order_id', $id)->where('phase_seq', 1)->count();
            // if ($count_material == 0) {
            //     throw new Exception('Material Belum Diisi');
            // }

            $data->status = "manufacturing 2";

            $log                 = new TrackingLog();
            $log->sales_order_id = $id;
            $log->status         = "manufacturing 2";
            $log->created_by     = auth()->user()->id;
            $log->updated_by     = auth()->user()->id;
            $log->save();

            $data->updated_by = Auth::user()->id;
            $data->save();

            return response()->json(['success' => true, 'message' => 'Pindah data berhasil']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function move_product_manufacturing_3($id)
    {
        try {
            $data   = SalesOrder::find($id);

            $photo = $data->photo_manufacturing_2;
            if ($photo == null) {
                throw new Exception('Photo manufacturing 2 Belum Diupload');
            }

            // $count_material = ManufactureMaterial::where('sales_order_id', $id)->where('phase_seq', 2)->count();
            // if ($count_material == 0) {
            //     throw new Exception('Material Belum Diisi');
            // }

            $data->status = "manufacturing 3";

            $log                 = new TrackingLog();
            $log->sales_order_id = $id;
            $log->status         = "manufacturing 3";
            $log->created_by     = auth()->user()->id;
            $log->updated_by     = auth()->user()->id;
            $log->save();

            $data->updated_by = Auth::user()->id;
            $data->save();

            return response()->json(['success' => true, 'message' => 'Pindah data berhasil']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function move_product_manufacturing_infuse($id)
    {
        try {
            $data   = SalesOrder::find($id);

            $photo = $data->photo_manufacturing_cutting;
            if ($photo == null) {
                throw new Exception('Photo manufacturing cutting Belum Diupload');
            }

            // $count_material = ManufactureMaterial::where('sales_order_id', $id)->where('phase_seq', 'cutting')->count();
            // if ($count_material == 0) {
            //     throw new Exception('Material Belum Diisi');
            // }

            $data->status = "manufacturing infuse";

            $log                 = new TrackingLog();
            $log->sales_order_id = $id;
            $log->status         = "manufacturing infuse";
            $log->created_by     = auth()->user()->id;
            $log->updated_by     = auth()->user()->id;
            $log->save();

            $data->updated_by = Auth::user()->id;
            $data->save();

            return response()->json(['success' => true, 'message' => 'Pindah data berhasil']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function move_product_finishing_1($id)
    {
        try {
            $data   = SalesOrder::find($id);

            $photo = $data->photo_manufacturing_3;
            if ($photo == null) {
                throw new Exception('Photo manufacturing 3 Belum Diupload');
            }

            // $count_material = ManufactureMaterial::where('sales_order_id', $id)->where('phase_seq', 3)->count();
            // if ($count_material == 0) {
            //     throw new Exception('Material Belum Diisi');
            // }

            $data->status = "finishing 1";

            $log                 = new TrackingLog();
            $log->sales_order_id = $id;
            $log->status         = "finishing 1";
            $log->created_by     = auth()->user()->id;
            $log->updated_by     = auth()->user()->id;
            $log->save();

            $data->updated_by = Auth::user()->id;
            $data->save();

            return response()->json(['success' => true, 'message' => 'Pindah data berhasil']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function move_product_finishing_1_infuse($id)
    {
        try {
            $data   = SalesOrder::find($id);

            $photo = $data->photo_manufacturing_infuse;
            if ($photo == null) {
                throw new Exception('Photo manufacturing Infuse Belum Diupload');
            }

            // $count_material = ManufactureMaterial::where('sales_order_id', $id)->where('phase_seq', 'infuse')->count();
            // if ($count_material == 0) {
            //     throw new Exception('Material Belum Diisi');
            // }

            $data->status = "finishing 1";

            $log                 = new TrackingLog();
            $log->sales_order_id = $id;
            $log->status         = "finishing 1";
            $log->created_by     = auth()->user()->id;
            $log->updated_by     = auth()->user()->id;
            $log->save();

            $data->updated_by = Auth::user()->id;
            $data->save();

            return response()->json(['success' => true, 'message' => 'Pindah data berhasil']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function move_product_finishing_2($id)
    {
        try {
            $data   = SalesOrder::find($id);

            $photo = $data->photo_finishing_1;
            if ($photo == null) {
                throw new Exception('Photo finishing 1 Belum Diupload');
            }

            // $count_material = ManufactureMaterial::where('sales_order_id', $id)->where('phase_seq', 'finishing 1')->count();
            // if ($count_material == 0) {
            //     throw new Exception('Material Belum Diisi');
            // }

            $data->status = "finishing 2";

            $log                 = new TrackingLog();
            $log->sales_order_id = $id;
            $log->status         = "finishing 2";
            $log->created_by     = auth()->user()->id;
            $log->updated_by     = auth()->user()->id;
            $log->save();

            $data->updated_by = Auth::user()->id;
            $data->save();

            return response()->json(['success' => true, 'message' => 'Pindah data berhasil']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function move_product_finishing_3($id)
    {
        try {
            $data   = SalesOrder::find($id);

            $photo = $data->photo_finishing_2;
            if ($photo == null) {
                throw new Exception('Photo finishing 2 Belum Diupload');
            }

            // $count_material = ManufactureMaterial::where('sales_order_id', $id)->where('phase_seq', 'finishing 2')->count();
            // if ($count_material == 0) {
            //     throw new Exception('Material Belum Diisi');
            // }

            $data->status = "finishing 3";

            $log                 = new TrackingLog();
            $log->sales_order_id = $id;
            $log->status         = "finishing 3";
            $log->created_by     = auth()->user()->id;
            $log->updated_by     = auth()->user()->id;
            $log->save();

            $data->updated_by = Auth::user()->id;
            $data->save();

            return response()->json(['success' => true, 'message' => 'Pindah data berhasil']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function move_product_rfs($id)
    {
        try {
            $data   = SalesOrder::find($id);

            $photo = $data->photo_finishing_3;
            if ($photo == null) {
                throw new Exception('Photo finishing 3 Belum Diupload');
            }

            // $count_material = ManufactureMaterial::where('sales_order_id', $id)->where('phase_seq', 'finishing 3')->count();
            // if ($count_material == 0) {
            //     throw new Exception('Material Belum Diisi');
            // }

            $data->status = "rfs";

            $log                 = new TrackingLog();
            $log->sales_order_id = $id;
            $log->status         = "rfs";
            $log->created_by     = auth()->user()->id;
            $log->updated_by     = auth()->user()->id;
            $log->save();

            $data->updated_by = Auth::user()->id;
            $data->save();

            return response()->json(['success' => true, 'message' => 'Pindah data berhasil']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    // end move

    public function store_status_pure(Request $request)
    {
        try {
            $sales_order_id = $request->sales_order_id;
            $status_pure = $request->status_pure;

            PureStatusLog::create([
                'sales_order_id' => $sales_order_id,
                'notes'          => $status_pure,
                'created_by'     => auth()->user()->id,
                'updated_by'     => auth()->user()->id,
            ]);

            SalesOrder::find($sales_order_id)->update([
                'notes'      => $status_pure,
                'updated_by' => Auth::user()->id,
            ]);
            return response()->json(['success' => true, 'message' => "success"]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function get_status_pure($id)
    {
        try {
            $data = PureStatusLog::with('created_name')->where('sales_order_id', $id)->latest()->get();
            return response()->json(['success' => true, 'data' => $data, 'message' => "success"]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'data' => [], 'message' => $e->getMessage()]);
        }
    }

    public function destroy_status_pure($id)
    {
        try {
            $data = PureStatusLog::find($id);
            $sales_order_id = $data->sales_order_id;
            $data->delete();

            $l = PureStatusLog::where('sales_order_id', $sales_order_id)->latest()->first();

            if ($l) {
                SalesOrder::where('id', $sales_order_id)->update([
                    'notes'      => $l->notes,
                    'updated_by' => auth()->user()->id,
                ]);
            } else {
                SalesOrder::where('id', $sales_order_id)->update([
                    'notes'      => null,
                    'updated_by' => auth()->user()->id,
                ]);
            }

            return response()->json(['success' => true, 'data' => $data, 'message' => "success"]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'data' => [], 'message' => $e->getMessage()]);
        }
    }

    public function update_sales_order_pure(Request $request)
    {
        $dp_pure                = $request->dp_pure;
        $sub_molding_id_pure    = $request->sub_molding_id_pure;
        $cost_molding_pure      = $request->cost_molding_pure;
        $sales_order_id_pure    = $request->sales_order_id_pure;

        $data = [
            'dp'                => $dp_pure,
            'sub_molding_id'    => $sub_molding_id_pure,
            'cost_molding_pure' => $cost_molding_pure,
        ];

        SalesOrder::where('id', $sales_order_id_pure)->update($data);

        return response()->json([
            'success' => true,
            'message' => 'success',
        ]);
    }

    public function update_sales_order_skinning(Request $request)
    {
        try {
            DB::beginTransaction();

            $dp_skinning             = $request->dp_skinning;
            $panjang_skinning        = $request->panjang_skinning;
            $lebar_skinning          = $request->lebar_skinning;
            $stock_id                = $request->stock_id;
            $sales_order_id_skinning = $request->sales_order_id_skinning;

            $stock = StockMonitor::with('master_barang')->find($stock_id);

            if (!$stock) {
                throw new Exception("Material tidak ditemukan");
            }

            if ($panjang_skinning > $stock->panjang) {
                throw new Exception("Panjang Material tidak mencukupi");
            }

            if ($lebar_skinning > $stock->lebar) {
                throw new Exception("Lebar Material tidak mencukupi");
            }

            // adam
            $stock_harga_jual = $stock->harga_jual;
            $stock_panjang    = $stock->panjang;
            $stock_lebar      = $stock->lebar;
            $luas_ruang_total = $stock_panjang * $stock_lebar;
            $harga_dasar      = $stock_harga_jual / $luas_ruang_total;
            $luas_potong      = $panjang_skinning * $lebar_skinning;
            $harga_jual       = $luas_potong * $harga_dasar;

            $data = [
                'dp'                      => $dp_skinning,
                'panjang_skinning'        => $panjang_skinning,
                'lebar_skinning'          => $lebar_skinning,
                'harga_material_skinning' => $harga_jual,
                'stock_monitor_id'        => $stock_id,
            ];

            SalesOrder::where('id', $sales_order_id_skinning)->update($data);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'success',
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
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

    public function destroy($id)
    {
        $motif = SalesOrder::find($id);
        $track = TrackingLog::where("sales_order_id", $id)->count();
        if ($track > 0) {
            $motif->tracking_log()->delete();
        }
        $motif->deleted_by = auth()->user()->id;
        $motif->delete();

        return response()->json(['success' => true]);
    }
}
