<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sensor;


class SensorSeeder extends Seeder
{
    public function run()
    {
        $sensors = [
            ['name' => 'Colombo Central', 'latitude' => 6.9271, 'longitude' => 79.8612, 'status' => 'active'],
            ['name' => 'Dehiwala', 'latitude' => 6.8500, 'longitude' => 79.8678, 'status' => 'active'],
            ['name' => 'Kotte', 'latitude' => 6.9000, 'longitude' => 79.9500, 'status' => 'inactive'],
            ['name' => 'Nugegoda', 'latitude' => 6.8700, 'longitude' => 79.8850, 'status' => 'active'],
            ['name' => 'Maharagama', 'latitude' => 6.8450, 'longitude' => 79.9240, 'status' => 'inactive'],
        ];

        foreach ($sensors as $sensor) {
            Sensor::create($sensor);
        }
    }
}