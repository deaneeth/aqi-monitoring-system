<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Sensor;
use App\Models\SensorData;
use App\Models\SimulationSetting;
use Carbon\Carbon;

class SimulateAQIData extends Command
{
    protected $signature = 'simulate:aqi';
    protected $description = 'Simulate AQI data for all active sensors';

    public function handle()
    {
        $settings = SimulationSetting::first();

        if (!$settings || $settings->status !== 'active') {
            $this->info('Simulation is inactive or not configured.');
            return;
        }

        $pattern = $settings->pattern ?? 'random';
        $variation = $settings->variation_range ?? 10;
        $now = now();

        $sensors = Sensor::where('status', 'active')->get();

        foreach ($sensors as $sensor) {
            $baseline = $sensor->baseline_aqi ?? 50;

            // ✅ Skip if a reading already exists within the last 5 minutes
            $recent = SensorData::where('sensor_id', $sensor->id)
                ->where('timestamp', '>=', $now->subMinutes(5))
                ->exists();

            if ($recent) {
                continue;
            }

            // 🔁 Pattern-based AQI simulation
            $aqi = match ($pattern) {
                'wave' => $baseline + sin(deg2rad($now->minute * 6)) * $variation,

                'rush_hour' => in_array($now->hour, [7, 8, 17, 18])
                    ? $baseline + rand($variation, $variation * 2)
                    : $baseline - rand(0, $variation),

                'industrial' => $now->minute % 30 === 0
                    ? $baseline + rand($variation * 2, $variation * 3)
                    : $baseline + rand(-$variation, $variation),

                'stable' => $baseline + rand(-2, 2),

                'weather' => rand(0, 10) > 7
                    ? $baseline - rand(10, 30) // simulate drop due to “rain”
                    : $baseline + rand(-$variation, $variation),

                'cumulative' => $baseline + ($now->hour * 2) + rand(0, 5),

                'night_recovery' => ($now->hour >= 21 || $now->hour <= 5)
                    ? $baseline - rand(10, 20)
                    : $baseline + rand(-$variation, $variation),

                default => $baseline + rand(-$variation, $variation),
            };

            $aqi = max(0, round($aqi)); // ⛔ Ensure AQI is not negative

            // ✅ Create AQI data
            SensorData::create([
                'sensor_id' => $sensor->id,
                'aqi' => $aqi,
                'timestamp' => $now,
            ]);
        }

        $this->info('✅ AQI simulated for ' . $sensors->count() . ' sensors using "' . $pattern . '" pattern.');
    }
}
