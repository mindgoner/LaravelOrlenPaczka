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
        Schema::create('orlen_paczka_locations', function (Blueprint $table) {
            $table->string('DestinationCode', 15);
            $table->string('StreetName', 40);
            $table->string('City', 30);
            $table->string('District', 30)->nullable();
            $table->string('Longitude', 15);
            $table->string('Latitude', 15);
            $table->string('Province', 30);
            $table->boolean('CashOnDelivery');
            $table->string('OpeningHours', 60);
            $table->string('Location', 255);
            $table->string('PSD', 10)->unique();
            $table->char('Available', 1);
            $table->string('Obszar', 30)->nullable();
            $table->string('Mikrorejon', 30)->nullable();
            $table->string('Skrotnrpok', 30)->nullable();
            $table->string('Sortownia', 30)->nullable();
            $table->string('Presort', 30)->nullable();
            $table->string('PointType', 30)->nullable();
            $table->string('Czas', 30)->nullable();
            $table->timestamps();

            $table->primary('DestinationCode');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orlen_paczka_locations');
    }
};
