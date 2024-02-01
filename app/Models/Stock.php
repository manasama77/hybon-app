<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'kode_barang',
        'stock_monitor_id',
        'tipe_stock',
        'panjang',
        'lebar',
        'qty',
        'harga_jual',
        'status',
        'sales_order_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function stock_monitor()
    {
        return $this->belongsTo(StockMonitor::class, 'stock_monitor_id', 'id')->withTrashed();
    }

    public function sales_order()
    {
        return $this->belongsTo(SalesOrder::class, 'sales_order_id', 'id');
    }

    public function created_name()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function scopeWithOutStockCount($query)
    {
        return $query->addSelect([
            'out_stock_count' => Stock::from('stocks as xxx')->selectRaw('count(*)')
                ->whereColumn('xxx.kode_barang', 'stocks.kode_barang')
                ->where('xxx.status', 'out')
        ]);
    }
}
