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
    Schema::table('sensors', function (Blueprint $table) {
        $table->integer('baseline_aqi')->default(50);
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
{
    Schema::table('sensors', function (Blueprint $table) {
        $table->dropColumn('baseline_aqi');
    });
}
};
