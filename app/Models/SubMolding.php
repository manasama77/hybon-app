<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubMolding extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'metode_molding_id',
        'name',
    ];

    public function metode_molding()
    {
        return $this->belongsTo(MetodeMolding::class);
    }
}
