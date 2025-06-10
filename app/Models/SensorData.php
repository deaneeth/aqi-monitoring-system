<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensorData extends Model
{
    use HasFactory;

    public function sensor()
{
    return $this->belongsTo(Sensor::class);

}
protected $fillable = [
    'sensor_id',
    'aqi',
    'timestamp',
];
public static function getAQILevel($aqi)
{
    $level = \App\Models\AlertThreshold::where('min_aqi', '<=', $aqi)
        ->where('max_aqi', '>=', $aqi)
        ->first();

    // Fallback if no match found
    if (!$level) {
        return (object)[
            'level_name' => 'Unknown',
            'color_code' => '#6c757d' // Gray
        ];
    }

    return $level;
}



}
