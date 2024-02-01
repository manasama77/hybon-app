<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\BarangJadiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Finishing1Controller;
use App\Http\Controllers\Finishing2Controller;
use App\Http\Controllers\Finishing3Controller;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Manufacturing1Controller;
use App\Http\Controllers\Manufacturing2Controller;
use App\Http\Controllers\Manufacturing3Controller;
use App\Http\Controllers\ManufacturingCuttingController;
use App\Http\Controllers\ManufacturingInfuseController;
use App\Http\Controllers\MasterBarangController;
use App\Http\Controllers\MetodeMoldingController;
use App\Http\Controllers\MotifController;
use App\Http\Controllers\OrderFromController;
use App\Http\Controllers\ProductDesignController;
use App\Http\Controllers\RfsController;
use App\Http\Controllers\RfsLunasController;
use App\Http\Controllers\SalesOrderController;
use App\Http\Controllers\StockInController;
use App\Http\Controllers\StockMonitorController;
use App\Http\Controllers\StockOutController;
use App\Http\Controllers\SubMoldingController;
use App\Http\Controllers\TipeBarangController;
use App\Http\Controllers\UserManagementController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [LandingController::class, 'index']);

Route::get('/login', [AuthenticatedSessionController::class, 'create']);

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/sales-order', [SalesOrderController::class, 'index'])->name('sales-order');
    Route::get('/sales-order/create', [SalesOrderController::class, 'create'])->name('sales-order.create');
    Route::post('/sales-order/store', [SalesOrderController::class, 'store'])->name('sales-order.store');
    Route::get('/sales-order/edit/{id}', [SalesOrderController::class, 'edit'])->name('sales-order.edit');
    Route::post('/sales-order/update/{id}', [SalesOrderController::class, 'update'])->name('sales-order.update');
    Route::post('/sales-order/destroy/{id}', [SalesOrderController::class, 'destroy'])->name('sales-order.destroy');

    Route::get('/product-design', [ProductDesignController::class, 'index'])->name('product-design');
    Route::post('/sales-order/update_sales_order_pure', [SalesOrderController::class, 'update_sales_order_pure'])->name('sales-order.update_sales_order_pure');
    Route::post('/sales-order/update_sales_order_skinning', [SalesOrderController::class, 'update_sales_order_skinning'])->name('sales-order.update_sales_order_skinning');
    Route::post('/sales-order/store_status_pure', [SalesOrderController::class, 'store_status_pure'])->name('sales-order.store_status_pure');
    Route::get('/sales-order/get_status_pure/{id}', [SalesOrderController::class, 'get_status_pure'])->name('sales-order.get_status_pure');
    Route::post('/sales-order/destroy_status_pure/{id}', [SalesOrderController::class, 'destroy_status_pure'])->name('sales-order.destroy_status_pure');

    // process move
    Route::post('/sales-order/move/product-design/{id}', [SalesOrderController::class, 'move_product_design'])->name('sales-order.move.product-design');
    Route::post('/sales-order/move/manufacturing/{id}', [SalesOrderController::class, 'move_product_manufacturing'])->name('sales-order.move.manufacturing');
    Route::post('/sales-order/move/manufacturing-2/{id}', [SalesOrderController::class, 'move_product_manufacturing_2'])->name('sales-order.move.manufacturing-2');
    Route::post('/sales-order/move/manufacturing-3/{id}', [SalesOrderController::class, 'move_product_manufacturing_3'])->name('sales-order.move.manufacturing-3');
    Route::post('/sales-order/move/manufacturing-infuse/{id}', [SalesOrderController::class, 'move_product_manufacturing_infuse'])->name('sales-order.move.manufacturing-infuse');
    Route::post('/sales-order/move/finishing-1/{id}', [SalesOrderController::class, 'move_product_finishing_1'])->name('sales-order.move.finishing-1');
    Route::post('/sales-order/move/finishing-1-infuse/{id}', [SalesOrderController::class, 'move_product_finishing_1_infuse'])->name('sales-order.move.finishing-1-infuse');
    Route::post('/sales-order/move/finishing-2/{id}', [SalesOrderController::class, 'move_product_finishing_2'])->name('sales-order.move.finishing-2');
    Route::post('/sales-order/move/finishing-3/{id}', [SalesOrderController::class, 'move_product_finishing_3'])->name('sales-order.move.finishing-3');
    Route::post('/sales-order/move/rfs/{id}', [SalesOrderController::class, 'move_product_rfs'])->name('sales-order.move.rfs');

    Route::get('/sales-order/show/{id}/{metode}', [SalesOrderController::class, 'show'])->name('sales-order.show');
    Route::get('/sales-order/show_for_manufacturing/{id}', [SalesOrderController::class, 'show_for_manufacturing'])->name('sales-order.show_for_manufacturing');
    Route::get('/sales-order/show_manufacturing_log/{id}', [SalesOrderController::class, 'show_manufacturing_log'])->name('sales-order.show_manufacturing_log');

    Route::get('/manufacturing-1', [Manufacturing1Controller::class, 'index'])->name('manufacturing-1');
    Route::post('/manufacturing-1/update/{sales_order_id}', [Manufacturing1Controller::class, 'update'])->name('manufacturing-1.update');
    Route::post('/manufacturing-1/store_material', [Manufacturing1Controller::class, 'store_material'])->name('manufacturing-1.store_material');
    Route::get('/manufacturing-1/show-material/{sales_order_id}', [Manufacturing1Controller::class, 'show_material'])->name('manufacturing-1.show-material');
    Route::post('/manufacturing-1/destroy-material', [Manufacturing1Controller::class, 'destroy_material'])->name('manufacturing-1.destroy-material');

    Route::get('/manufacturing-2', [Manufacturing2Controller::class, 'index'])->name('manufacturing-2');
    Route::post('/manufacturing-2/update/{sales_order_id}', [Manufacturing2Controller::class, 'update'])->name('manufacturing-2.update');
    Route::post('/manufacturing-2/store_material', [Manufacturing2Controller::class, 'store_material'])->name('manufacturing-2.store_material');
    Route::get('/manufacturing-2/show-material/{sales_order_id}', [Manufacturing2Controller::class, 'show_material'])->name('manufacturing-2.show-material');
    Route::post('/manufacturing-2/destroy-material', [Manufacturing2Controller::class, 'destroy_material'])->name('manufacturing-2.destroy-material');

    Route::get('/manufacturing-3', [Manufacturing3Controller::class, 'index'])->name('manufacturing-3');
    Route::post('/manufacturing-3/update/{sales_order_id}', [Manufacturing3Controller::class, 'update'])->name('manufacturing-3.update');
    Route::post('/manufacturing-3/store_material', [Manufacturing3Controller::class, 'store_material'])->name('manufacturing-3.store_material');
    Route::get('/manufacturing-3/show-material/{sales_order_id}', [Manufacturing3Controller::class, 'show_material'])->name('manufacturing-3.show-material');
    Route::post('/manufacturing-3/destroy-material', [Manufacturing3Controller::class, 'destroy_material'])->name('manufacturing-3.destroy-material');

    Route::get('/manufacturing-cutting', [ManufacturingCuttingController::class, 'index'])->name('manufacturing-cutting');
    Route::post('/manufacturing-cutting/update/{sales_order_id}', [ManufacturingCuttingController::class, 'update'])->name('manufacturing-cutting.update');
    Route::post('/manufacturing-cutting/store_material', [ManufacturingCuttingController::class, 'store_material'])->name('manufacturing-cutting.store_material');
    Route::get('/manufacturing-cutting/show-material/{sales_order_id}', [ManufacturingCuttingController::class, 'show_material'])->name('manufacturing-cutting.show-material');
    Route::post('/manufacturing-cutting/destroy-material', [ManufacturingCuttingController::class, 'destroy_material'])->name('manufacturing-cutting.destroy-material');

    Route::get('/manufacturing-infuse', [ManufacturingInfuseController::class, 'index'])->name('manufacturing-infuse');
    Route::post('/manufacturing-infuse/update/{sales_order_id}', [ManufacturingInfuseController::class, 'update'])->name('manufacturing-infuse.update');
    Route::post('/manufacturing-infuse/store_material', [ManufacturingInfuseController::class, 'store_material'])->name('manufacturing-infuse.store_material');
    Route::get('/manufacturing-infuse/show-material/{sales_order_id}', [ManufacturingInfuseController::class, 'show_material'])->name('manufacturing-infuse.show-material');
    Route::post('/manufacturing-infuse/destroy-material', [ManufacturingInfuseController::class, 'destroy_material'])->name('manufacturing-infuse.destroy-material');

    Route::get('/finishing-1', [Finishing1Controller::class, 'index'])->name('finishing-1');
    Route::post('/finishing-1/update/{sales_order_id}', [Finishing1Controller::class, 'update'])->name('finishing-1.update');
    Route::post('/finishing-1/store_material', [Finishing1Controller::class, 'store_material'])->name('finishing-1.store_material');
    Route::get('/finishing-1/show-material/{sales_order_id}', [Finishing1Controller::class, 'show_material'])->name('finishing-1.show-material');
    Route::post('/finishing-1/destroy-material', [Finishing1Controller::class, 'destroy_material'])->name('finishing-1.destroy-material');

    Route::get('/finishing-2', [Finishing2Controller::class, 'index'])->name('finishing-2');
    Route::post('/finishing-2/update/{sales_order_id}', [Finishing2Controller::class, 'update'])->name('finishing-2.update');
    Route::post('/finishing-2/store_material', [Finishing2Controller::class, 'store_material'])->name('finishing-2.store_material');
    Route::get('/finishing-2/show-material/{sales_order_id}', [Finishing2Controller::class, 'show_material'])->name('finishing-2.show-material');
    Route::post('/finishing-2/destroy-material', [Finishing2Controller::class, 'destroy_material'])->name('finishing-2.destroy-material');

    Route::get('/finishing-3', [Finishing3Controller::class, 'index'])->name('finishing-3');
    Route::post('/finishing-3/update/{sales_order_id}', [Finishing3Controller::class, 'update'])->name('finishing-3.update');
    Route::post('/finishing-3/store_material', [Finishing3Controller::class, 'store_material'])->name('finishing-3.store_material');
    Route::get('/finishing-3/show-material/{sales_order_id}', [Finishing3Controller::class, 'show_material'])->name('finishing-3.show-material');
    Route::post('/finishing-3/destroy-material', [Finishing3Controller::class, 'destroy_material'])->name('finishing-3.destroy-material');

    Route::get('/rfs', [RfsController::class, 'index'])->name('rfs');
    Route::post('/rfs/update/{sales_order_id}', [RfsController::class, 'update'])->name('rfs.update');

    Route::get('/rfs-lunas', [RfsLunasController::class, 'index'])->name('rfs-lunas');


    Route::prefix('warehouse')->group(function () {
        Route::get('/master-barang', [MasterBarangController::class, 'index'])->name('warehouse.master-barang');
        Route::get('/master-barang/show/{id}', [MasterBarangController::class, 'show'])->name('warehouse.master-barang.show');
        Route::get('/master-barang/create', [MasterBarangController::class, 'create'])->name('warehouse.master-barang.create');
        Route::post('/master-barang/store', [MasterBarangController::class, 'store'])->name('warehouse.master-barang.store');
        Route::get('/master-barang/edit/{id}', [MasterBarangController::class, 'edit'])->name('warehouse.master-barang.edit');
        Route::post('/master-barang/update/{id}', [MasterBarangController::class, 'update'])->name('warehouse.master-barang.update');
        Route::post('/master-barang/destroy/{id}', [MasterBarangController::class, 'destroy'])->name('warehouse.master-barang.destroy');

        Route::get('/stock-monitor', [StockMonitorController::class, 'index'])->name('warehouse.stock-monitor');
        Route::get('/stock-monitor/edit/{id}', [StockMonitorController::class, 'edit'])->name('warehouse.stock-monitor.edit');
        Route::post('/stock-monitor/update/{id}', [StockMonitorController::class, 'update'])->name('warehouse.stock-monitor.update');
        Route::post('/stock-monitor/destroy/{id}', [StockMonitorController::class, 'destroy'])->name('warehouse.stock-monitor.destroy');

        Route::get('/stock-in', [StockInController::class, 'index'])->name('warehouse.stock-in');
        Route::get('/stock-in/create', [StockInController::class, 'create'])->name('warehouse.stock-in.create');
        Route::post('/stock-in/store', [StockInController::class, 'store'])->name('warehouse.stock-in.store');
        Route::post('/stock-in/destroy/{id}', [StockInController::class, 'destroy'])->name('warehouse.stock-in.destroy');

        Route::get('/stock-out', [StockOutController::class, 'index'])->name('warehouse.stock-out');
    });

    Route::prefix('data-reference')->group(function () {
        Route::get('/barang-jadi', [BarangJadiController::class, 'index'])->name('data-reference.barang-jadi');
        Route::get('/barang-jadi/show/{id}', [BarangJadiController::class, 'show'])->name('data-reference.barang-jadi.show');
        Route::get('/barang-jadi/create', [BarangJadiController::class, 'create'])->name('data-reference.barang-jadi.create');
        Route::post('/barang-jadi/store', [BarangJadiController::class, 'store'])->name('data-reference.barang-jadi.store');
        Route::get('/barang-jadi/edit/{id}', [BarangJadiController::class, 'edit'])->name('data-reference.barang-jadi.edit');
        Route::post('/barang-jadi/update/{id}', [BarangJadiController::class, 'update'])->name('data-reference.barang-jadi.update');
        Route::post('/barang-jadi/destroy/{id}', [BarangJadiController::class, 'destroy'])->name('data-reference.barang-jadi.destroy');

        Route::get('/motif', [MotifController::class, 'index'])->name('data-reference.motif');
        Route::get('/motif/create', [MotifController::class, 'create'])->name('data-reference.motif.create');
        Route::post('/motif/store', [MotifController::class, 'store'])->name('data-reference.motif.store');
        Route::get('/motif/edit/{id}', [MotifController::class, 'edit'])->name('data-reference.motif.edit');
        Route::post('/motif/update/{id}', [MotifController::class, 'update'])->name('data-reference.motif.update');
        Route::post('/motif/destroy/{id}', [MotifController::class, 'destroy'])->name('data-reference.motif.destroy');

        Route::get('/tipe-barang', [TipeBarangController::class, 'index'])->name('data-reference.tipe-barang');
        Route::get('/tipe-barang/create', [TipeBarangController::class, 'create'])->name('data-reference.tipe-barang.create');
        Route::post('/tipe-barang/store', [TipeBarangController::class, 'store'])->name('data-reference.tipe-barang.store');
        Route::get('/tipe-barang/edit/{id}', [TipeBarangController::class, 'edit'])->name('data-reference.tipe-barang.edit');
        Route::post('/tipe-barang/update/{id}', [TipeBarangController::class, 'update'])->name('data-reference.tipe-barang.update');
        Route::post('/tipe-barang/destroy/{id}', [TipeBarangController::class, 'destroy'])->name('data-reference.tipe-barang.destroy');

        Route::get('/order-from', [OrderFromController::class, 'index'])->name('data-reference.order-from');
        Route::get('/order-from/create', [OrderFromController::class, 'create'])->name('data-reference.order-from.create');
        Route::post('/order-from/store', [OrderFromController::class, 'store'])->name('data-reference.order-from.store');
        Route::get('/order-from/edit/{id}', [OrderFromController::class, 'edit'])->name('data-reference.order-from.edit');
        Route::post('/order-from/update/{id}', [OrderFromController::class, 'update'])->name('data-reference.order-from.update');
        Route::post('/order-from/destroy/{id}', [OrderFromController::class, 'destroy'])->name('data-reference.order-from.destroy');

        Route::get('/metode-molding', [MetodeMoldingController::class, 'index'])->name('data-reference.metode-molding');
        Route::get('/metode-molding/create', [MetodeMoldingController::class, 'create'])->name('data-reference.metode-molding.create');
        Route::post('/metode-molding/store', [MetodeMoldingController::class, 'store'])->name('data-reference.metode-molding.store');
        Route::get('/metode-molding/edit/{id}', [MetodeMoldingController::class, 'edit'])->name('data-reference.metode-molding.edit');
        Route::post('/metode-molding/update/{id}', [MetodeMoldingController::class, 'update'])->name('data-reference.metode-molding.update');
        Route::post('/metode-molding/destroy/{id}', [MetodeMoldingController::class, 'destroy'])->name('data-reference.metode-molding.destroy');

        Route::get('/sub-molding', [SubMoldingController::class, 'index'])->name('data-reference.sub-molding');
        Route::get('/sub-molding/show/{id}', [SubMoldingController::class, 'show'])->name('data-reference.sub-molding.show');
        Route::get('/sub-molding/create', [SubMoldingController::class, 'create'])->name('data-reference.sub-molding.create');
        Route::post('/sub-molding/store', [SubMoldingController::class, 'store'])->name('data-reference.sub-molding.store');
        Route::get('/sub-molding/edit/{id}', [SubMoldingController::class, 'edit'])->name('data-reference.sub-molding.edit');
        Route::post('/sub-molding/update/{id}', [SubMoldingController::class, 'update'])->name('data-reference.sub-molding.update');
        Route::post('/sub-molding/destroy/{id}', [SubMoldingController::class, 'destroy'])->name('data-reference.sub-molding.destroy');
    });

    Route::get('/user-management', [UserManagementController::class, 'index'])->name('user-management');
    Route::get('/user-management/create', [UserManagementController::class, 'create'])->name('user-management.create');
    Route::post('/user-management/store', [UserManagementController::class, 'store'])->name('user-management.store');
    Route::get('/user-management/edit/{id}', [UserManagementController::class, 'edit'])->name('user-management.edit');
    Route::post('/user-management/update/{id}', [UserManagementController::class, 'update'])->name('user-management.update');
    Route::post('/user-management/destroy/{id}', [UserManagementController::class, 'destroy'])->name('user-management.destroy');
    Route::get('/user-management/reset-password/{id}', [UserManagementController::class, 'reset_password'])->name('user-management.reset-password');
    Route::post('/user-management/proses-reset-password/{id}', [UserManagementController::class, 'proses_reset_password'])->name('user-management.proses-reset-password');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
