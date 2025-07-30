<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('data', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('index_id');
            $table->string('location_name');
            $table->string('lat');
            $table->string('lng');
            // Tanah
            $table->integer('co2');
            $table->integer('hum');
            $table->integer('temp');

            // cahaya
            $table->integer('luminosity');

            // Udara
            $table->integer('airHumidity');
            $table->integer('conductivityValue');
            $table->integer('moistureValue');
            $table->integer('nitrogenValue');
            $table->integer('phValue');
            $table->integer('phosphorusValue');
            $table->integer('potassiumValue');
            $table->integer('temperatureValue');

            $table->integer('kesimpulan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data');
    }
};
