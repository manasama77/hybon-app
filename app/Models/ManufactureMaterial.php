<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ManufactureMaterial extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'sales_order_id',
        'stock_monitor_id',
        'metode',
        'qty',
        'panjang',
        'lebar',
        'price',
        'notes',
        'phase_seq',
        'revisi_seq',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $appends = [
        'price_formated',
    ];

    public function sales_order()
    {
        return $this->belongsTo(SalesOrder::class);
    }

    public function stock_monitor()
    {
        return $this->belongsTo(StockMonitor::class)->withTrashed();
    }

    public function getCreatedAtAttribute($value)
    {
        $date =  Carbon::parse($value)->timezone('Asia/Jakarta')->locale('id');
        $date->settings(['formatFunction' => 'translatedFormat']);
        return $date->format('l, j F Y; H:i');
    }

    public function getPriceFormatedAttribute()
    {
        return number_format($this->price, 2, ',', '.');
    }
}
