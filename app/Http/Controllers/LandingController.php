<?php

namespace App\Http\Controllers;

use App\Models\SalesOrder;
use App\Models\TrackingLog;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class LandingController extends Controller
{
    public function index(Request $request)
    {
        $data = [];
        $found = null;
        $sales = [];

        if ($request->code_order) {
            $code_order = $request->code_order;
            $sales      = SalesOrder::where('code_order', $code_order)->first();
            if (!$sales) {
                return view('layouts.landing', [
                    'data'  => $data,
                    'found' => false,
                    'sales' => $sales,
                ]);
            }

            $found      = true;
            $trackings  = TrackingLog::where('sales_order_id', $sales->id)->get();

            if ($sales->metode == "pure") {
                $data  = [
                    [
                        'status'  => 'sales order',
                        'icon'    => 'fa-solid fa-clipboard',
                        'dt'      => '-',
                        'success' => false,
                    ],
                    [
                        'status'  => 'product design',
                        'icon'    => 'fa-solid fa-clipboard',
                        'dt'      => '-',
                        'success' => false,
                    ],
                    [
                        'status'  => 'manufacturing cutting',
                        'icon'    => 'fa-solid fa-scissors',
                        'dt'      => '-',
                        'success' => false,
                    ],
                    [
                        'status'  => 'manufacturing infuse',
                        'icon'    => 'fa-solid fa-glass-water-droplet',
                        'dt'      => '-',
                        'success' => false,
                    ],
                    [
                        'status'  => 'finishing 1',
                        'icon'    => 'fa-solid fa-1',
                        'dt'      => '-',
                        'success' => false,
                    ],
                    [
                        'status'  => 'finishing 2',
                        'icon'    => 'fa-solid fa-2',
                        'dt'      => '-',
                        'success' => false,
                    ],
                    [
                        'status'  => 'finishing 3',
                        'icon'    => 'fa-solid fa-3',
                        'dt'      => '-',
                        'success' => false,
                    ],
                    [
                        'status'  => 'rfs',
                        'icon'    => 'fa-solid fa-boxes-packing',
                        'dt'      => '-',
                        'success' => false,
                    ],

                ];
            } else {
                $data  = [
                    [
                        'status'  => 'sales order',
                        'icon'    => 'fa-solid fa-clipboard',
                        'dt'      => '-',
                        'success' => false,
                    ],
                    [
                        'status'  => 'product design',
                        'icon'    => 'fa-solid fa-clipboard',
                        'dt'      => '-',
                        'success' => false,
                    ],
                    [
                        'status'  => 'manufacturing 1',
                        'icon'    => 'fa-solid fa-1',
                        'dt'      => '-',
                        'success' => false,
                    ],
                    [
                        'status'  => 'manufacturing 2',
                        'icon'    => 'fa-solid fa-2',
                        'dt'      => '-',
                        'success' => false,
                    ],
                    [
                        'status'  => 'manufacturing 3',
                        'icon'    => 'fa-solid fa-3',
                        'dt'      => '-',
                        'success' => false,
                    ],
                    [
                        'status'  => 'finishing 1',
                        'icon'    => 'fa-solid fa-1',
                        'dt'      => '-',
                        'success' => false,
                    ],
                    [
                        'status'  => 'finishing 2',
                        'icon'    => 'fa-solid fa-2',
                        'dt'      => '-',
                        'success' => false,
                    ],
                    [
                        'status'  => 'finishing 3',
                        'icon'    => 'fa-solid fa-3',
                        'dt'      => '-',
                        'success' => false,
                    ],
                    [
                        'status'  => 'rfs',
                        'icon'    => 'fa-solid fa-boxes-packing',
                        'dt'      => '-',
                        'success' => false,
                    ],

                ];
            }

            foreach ($trackings as $t) {
                $status = $t->status;
                $dt     = $t->created_at;

                foreach ($data as $k => $v) {
                    if ($v['status'] == $status) {
                        $data[$k]['dt']      = $dt;
                        $data[$k]['success'] = true;
                    }
                }
            }
        }

        return view('layouts.landing', [
            'data'  => $data,
            'found' => $found,
            'sales' => $sales,
        ]);
    }
}
