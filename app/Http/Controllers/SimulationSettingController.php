<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SimulationSetting;

class SimulationSettingController extends Controller
{
    public function index()
    {
        $settings = SimulationSetting::first(); // get current config
    return view('admin.simulation-settings', compact('settings'));
    }

    public function update(Request $request)
{
    $settings = SimulationSetting::first() ?? new SimulationSetting();

    $settings->variation_range = $request->variation_range;
    $settings->frequency = $request->frequency;
    $settings->pattern = $request->pattern;
    $settings->sensor_scope = $request->sensor_scope;
    $settings->status = $request->status;
    $settings->save();

    return back()->with('success', 'Simulation settings updated successfully.');
}

}
