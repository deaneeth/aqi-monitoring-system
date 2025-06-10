<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SensorData;
use Carbon\Carbon;

class SensorDataController extends Controller
{
    public function history($id)
    {
        $now = Carbon::now();
        $past24h = $now->subHours(24);

        $data = SensorData::where('sensor_id', $id)
            ->where('timestamp', '>=', $past24h)
            ->orderBy('timestamp')
            ->get(['aqi', 'timestamp']);

        return response()->json($data);
    }
}
