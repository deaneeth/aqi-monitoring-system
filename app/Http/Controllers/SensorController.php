<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sensor;
use App\Models\SensorData;

class SensorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sensors = Sensor::all();
        return view('sensors.index', compact('sensors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sensors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string',
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
        'status' => 'required|in:active,inactive',
        'baseline_aqi' => 'required|integer|min:0|max:500',
    ]);

    Sensor::create([
        'name' => $request->name,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'status' => $request->status,
        'baseline_aqi' => $request->baseline_aqi, // ✅ make sure this is here!
    ]);

    return redirect()->route('sensors.index')->with('success', 'Sensor added successfully!');
}


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $sensor = Sensor::findOrFail($id);
        return view('sensors.show', compact('sensor'));
    }

    /**
     * Show a map with all sensors.
     */
    public function map()
    {
        $sensors = Sensor::all();
        return view('sensors.map', compact('sensors'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $sensor = Sensor::findOrFail($id);
        return view('sensors.edit', compact('sensor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $sensor = Sensor::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        $sensor->update([
            'name' => $request->name,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return redirect()->route('sensors.index')->with('success', 'Sensor updated successfully.');
    }

    /**
     * Soft-delete (deactivate) the sensor.
     */
    public function destroy($id)
    {
        $sensor = Sensor::findOrFail($id);
        $sensor->update(['status' => 'inactive']);

        return redirect()->route('sensors.index')->with('success', 'Sensor deactivated successfully.');
    }

    /**
     * Reactivate a sensor.
     */
    public function activate($id)
    {
        $sensor = Sensor::findOrFail($id);
        $sensor->update(['status' => 'active']);

        return redirect()->route('sensors.index')->with('success', 'Sensor activated successfully!');
    }

    public function forceDelete($id)
{
    $sensor = Sensor::findOrFail($id);
    $sensor->delete(); // Hard delete
    return redirect()->route('sensors.index')->with('success', 'Sensor permanently deleted.');
}

}
