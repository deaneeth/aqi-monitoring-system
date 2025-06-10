<?php

// app/Http/Controllers/PublicMapController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sensor;
use App\Models\AlertThreshold;

class PublicMapController extends Controller
{
    public function index()
{
    $sensors = Sensor::where('status', 'active')
        ->with(['data' => function ($query) {
            $query->orderBy('timestamp', 'desc');
        }])
        ->get();

    // Ensure sensors with no data still appear
    $sensors = Sensor::with(['data' => function ($query) {
        $query->orderBy('timestamp', 'desc');
    }])->where('status', 'active')->get();

    $thresholds = AlertThreshold::orderBy('min_aqi')->get();

    return view('public.map', compact('sensors', 'thresholds'));
}

}
