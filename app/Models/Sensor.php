<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    use HasFactory;

    // Allow mass-assignment for these fields
    protected $fillable = [
        'name',
        'latitude',
        'longitude',
        'status',
        'baseline_aqi' // ✅ Add this
    ];



    // A sensor has many data points
    public function data()
{
    return $this->hasMany(\App\Models\SensorData::class);
}

}
