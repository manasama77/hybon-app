<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PureStatusLog extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'sales_order_id',
        'notes',
    ];

    public function sales_order()
    {
        return $this->belongsTo(SalesOrder::class);
    }

    public function getCreatedAtAttribute($value)
    {
        $date =  Carbon::parse($value)->timezone('Asia/Jakarta')->locale('id');
        $date->settings(['formatFunction' => 'translatedFormat']);
        return $date->format('l, j F Y; H:i');
    }
}
