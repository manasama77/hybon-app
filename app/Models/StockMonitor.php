<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockMonitor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'kode_barang',
        'master_barang_id',
        'tipe_stock',
        'panjang',
        'lebar',
        'qty',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function master_barang()
    {
        return $this->belongsTo(MasterBarang::class, 'master_barang_id');
    }
}
