<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('alert_thresholds', function (Blueprint $table) {
        $table->id();
        $table->string('level_name'); // Good, Moderate, Unhealthy...
        $table->integer('min_aqi');
        $table->integer('max_aqi');
        $table->string('color_code'); // e.g., "#00e400"
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alert_thresholds');
    }
};
