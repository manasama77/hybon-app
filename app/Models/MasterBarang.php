<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterBarang extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'tipe_barang_id',
        'nama_vendor',
        'tipe_stock',
        'satuan',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function setKodeBarangAttribute($value)
    {
        $this->attributes['kode_barang'] = strtoupper($value);
    }

    public function setNamaBarangAttribute($value)
    {
        $this->attributes['nama_barang'] = strtoupper($value);
    }

    public function tipe_barang()
    {
        return $this->belongsTo(TipeBarang::class, 'tipe_barang_id');
    }
}
