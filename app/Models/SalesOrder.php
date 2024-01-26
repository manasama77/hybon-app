<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code_order',
        'title',
        'motif_id',
        'metode',
        'dp',
        'harga_jual',
        'barang_jadi_id',
        'nama_customer',
        'alamat',
        'no_telp',
        'order_from_id',
        'status',
        'notes',
        'sub_molding_id',
        'cost_molding_pure',
        'panjang_skinning',
        'lebar_skinning',
        'harga_material_skinning',
        'stock_monitor_id',
        'photo_manufacturing_1',
        'revisi_manufacturing_1',
        'photo_manufacturing_2',
        'revisi_manufacturing_2',
        'photo_manufacturing_3',
        'revisi_manufacturing_3',
        'photo_manufacturing_cutting',
        'revisi_manufacturing_cutting',
        'photo_manufacturing_infuse',
        'revisi_manufacturing_infuse',
        'is_lunas',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function motif()
    {
        return $this->belongsTo(Motif::class);
    }

    public function barang_jadi()
    {
        return $this->belongsTo(BarangJadi::class);
    }

    public function order_from()
    {
        return $this->belongsTo(OrderFrom::class);
    }

    public function create_name()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function sub_molding()
    {
        return $this->belongsTo(SubMolding::class);
    }

    public function stock_monitor()
    {
        return $this->belongsTo(StockMonitor::class);
    }

    public function manufacture_materials()
    {
        $this->hasMany(ManufactureMaterial::class, 'sales_order_id', 'id');
    }

    public function tracking_log()
    {
        $this->hasMany(TrackingLog::class);
    }


    public function setNamaCustomerAttribute($value)
    {
        $this->attributes['nama_customer'] = strtoupper($value);
    }
}
