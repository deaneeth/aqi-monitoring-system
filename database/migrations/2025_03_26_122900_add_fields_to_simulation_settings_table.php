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
        Schema::table('simulation_settings', function (Blueprint $table) {
            $table->integer('frequency')->default(1); // minutes
            $table->string('pattern')->default('random');
            $table->string('sensor_scope')->default('all');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('simulation_settings', function (Blueprint $table) {
            //
        });
    }
};
