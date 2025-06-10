<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sensor;
use Illuminate\Http\Request;

class AlertsController extends Controller
{
    public function index()
    {
        $activeAlerts = Sensor::with(['data' => function ($q) {
            $q->latest();
        }])->get()->filter(function ($sensor) {
            return optional($sensor->data->first())->aqi > 350;
        });

        return view('admin.alerts.index', compact('activeAlerts'));
    }

}
