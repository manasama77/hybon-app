<?php

namespace App\Http\Controllers;

use App\Models\SalesOrder;
use App\Models\StockMonitor;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function get_materials()
    {
        $data = StockMonitor::select([
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
        return response()->json(['success' => true, 'data' => $data, 'message' => "success"]);
    }

    public function get_count_sidebar()
    {
        $sales_orders = SalesOrder::get();

        $c_sales_order           = 0;
        $c_product_design        = 0;
        $c_manufacturing_1       = 0;
        $c_manufacturing_2       = 0;
        $c_manufacturing_3       = 0;
        $c_manufacturing_cutting = 0;
        $c_manufacturing_infuse  = 0;
        $c_finishing_1           = 0;
        $c_finishing_2           = 0;
        $c_finishing_3           = 0;
        $c_rfs_pending           = 0;
        $c_rfs_lunas             = 0;

        foreach ($sales_orders as $s) {
            $status = $s->status;
            $is_lunas = $s->is_lunas;

            if ($status == "sales order") {
                $c_sales_order++;
            }
            if ($status == "product design") {
                $c_product_design++;
            }
            if ($status == "manufacturing 1") {
                $c_manufacturing_1++;
            }
            if ($status == "manufacturing 2") {
                $c_manufacturing_2++;
            }
            if ($status == "manufacturing 3") {
                $c_manufacturing_3++;
            }
            if ($status == "manufacturing cutting") {
                $c_manufacturing_cutting++;
            }
            if ($status == "manufacturing infuse") {
                $c_manufacturing_infuse++;
            }
            if ($status == "finishing 1") {
                $c_finishing_1++;
            }
            if ($status == "finishing 2") {
                $c_finishing_2++;
            }
            if ($status == "finishing 3") {
                $c_finishing_3++;
            }
            if ($status == "rfs") {
                if ($is_lunas == false) {
                    $c_rfs_pending++;
                } else {
                    $c_rfs_lunas++;
                }
            }
        }

        $data = [
            'c_sales_order'           => $c_sales_order,
            'c_product_design'        => $c_product_design,
            'c_manufacturing_1'       => $c_manufacturing_1,
            'c_manufacturing_2'       => $c_manufacturing_2,
            'c_manufacturing_3'       => $c_manufacturing_3,
            'c_manufacturing_cutting' => $c_manufacturing_cutting,
            'c_manufacturing_infuse'  => $c_manufacturing_infuse,
            'c_finishing_1'           => $c_finishing_1,
            'c_finishing_2'           => $c_finishing_2,
            'c_finishing_3'           => $c_finishing_3,
            'c_rfs_pending'           => $c_rfs_pending,
            'c_rfs_lunas'             => $c_rfs_lunas
        ];

        return response()->json($data);
    }
}
