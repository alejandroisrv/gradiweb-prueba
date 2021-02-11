<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    public $fillable = [
        'model',
        'owner_id',
        'brand_id',
        'vehicle_types_id',
        'placa'
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }
    public function type()
    {
        return $this->belongsTo(VehicleType::class, 'vehicle_types_id');
    }
}
