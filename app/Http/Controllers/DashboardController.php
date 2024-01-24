<?php

namespace App\Http\Controllers;

use App\Models\ManufactureMaterial;
use App\Models\SalesOrder;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $income  = $this->count_income();
        $expense = $this->count_expense();
        $order   = $this->count_order();
        $paid    = $this->count_paid_order();
        $unpaid  = $this->count_unpaid_order();
        $rfs     = $this->count_rfs();

        $data = [
            'income'  => $income,
            'expense' => $expense,
            'order'   => $order,
            'paid'    => $paid,
            'unpaid'  => $unpaid,
            'rfs'     => $rfs,
        ];
        return view('pages.dashboard.index', $data);
    }

    protected function count_income()
    {
        $sum_dp         = SalesOrder::where('is_lunas', false)->sum('dp');
        $sum_harga_jual = SalesOrder::where('is_lunas', true)->sum('harga_jual');

        return $sum_harga_jual + $sum_dp;
    }

    protected function count_expense()
    {
        $sum_cost_molding_pure       = SalesOrder::sum('cost_molding_pure');
        $sum_harga_material_skinning = SalesOrder::sum('harga_material_skinning');
        $sum_material                = ManufactureMaterial::sum('price');

        return $sum_cost_molding_pure + $sum_harga_material_skinning + $sum_material;
    }

    protected function count_order()
    {
        $count_order = SalesOrder::count();

        return $count_order;
    }

    protected function count_paid_order()
    {
        $count_order = SalesOrder::where('is_lunas', 1)->count();

        return $count_order;
    }

    protected function count_unpaid_order()
    {
        $count_order = SalesOrder::where('is_lunas', 0)->count();

        return $count_order;
    }

    protected function count_rfs()
    {
        $count_rfs = SalesOrder::where('status', 'rfs')->count();

        return $count_rfs;
    }
}
