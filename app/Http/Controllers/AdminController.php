<?php

namespace App\Http\Controllers;

use App\Models\Sensor;
use App\Models\SimulationSetting;
use App\Models\SensorData;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class AdminController extends Controller
{
    public function dashboard()
{
    $totalSensors = Sensor::count();
    $activeSensors = Sensor::where('status', 'active')->count();
    $inactiveSensors = Sensor::where('status', 'inactive')->count();

    $simulationStatus = SimulationSetting::first()?->status ?? 'inactive';

    // ✅ Alert: Filter by latest AQI > 350
    $activeAlerts = Sensor::with(['data' => function ($q) {
        $q->latest(); // Only get latest
    }])->get()->filter(function ($sensor) {
        return optional($sensor->data->first())->aqi > 350;
    });

    $aqiTrends = SensorData::selectRaw('HOUR(timestamp) as hour, AVG(aqi) as avg_aqi')
        ->where('timestamp', '>=', now()->subDay())
        ->groupBy('hour')
        ->get();

    return view('admin.dashboard', compact(
        'totalSensors',
        'activeSensors',
        'inactiveSensors',
        'simulationStatus',
        'aqiTrends',
        'activeAlerts'
    ));
}


public function showUploadForm()
{
    return view('admin.upload_csv');
}

public function handleCsvUpload(Request $request)
{
    $request->validate([
        'csv_file' => 'required|mimes:csv,txt',
    ]);

    $path = $request->file('csv_file')->storeAs('csv', 'data.csv');
    $fullPath = storage_path("app/{$path}");
    $file = fopen($fullPath, 'r');

    $header = fgetcsv($file); // Skip header row

    while (($row = fgetcsv($file)) !== false) {
        // [0] => name, [1] => latitude, [2] => longitude, [3] => aqi, [4] => timestamp
        $sensor = Sensor::firstOrCreate(
            [
                'name' => $row[0],
                'latitude' => $row[1],
                'longitude' => $row[2],
            ],
            [
                'status' => 'active',
                'baseline_aqi' => $row[5] ?? 50,
            ]
        );

        SensorData::create([
            'sensor_id' => $sensor->id,
            'aqi' => $row[3],
            'timestamp' => $row[4],
        ]);
    }

    fclose($file);

    return redirect()->back()->with('success', 'CSV data uploaded and imported successfully!');
}

public function alerts()
{
    $activeAlerts = Sensor::with(['data' => function ($q) {
        $q->latest();
    }])->get()->filter(function ($sensor) {
        return optional($sensor->data->first())->aqi > 350;
    });

    return view('admin.alerts', compact('activeAlerts'));
}


}
