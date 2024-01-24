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
        'stock_id',
        'qty',
        'price',
        'notes',
        'phase_seq',
        'revisi_seq',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function sales_order()
    {
        return $this->belongsTo(SalesOrder::class);
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }

    public function getCreatedAtAttribute($value)
    {
        $date =  Carbon::parse($value)->timezone('Asia/Jakarta')->locale('id');
        $date->settings(['formatFunction' => 'translatedFormat']);
        return $date->format('l, j F Y; H:i');
    }
}