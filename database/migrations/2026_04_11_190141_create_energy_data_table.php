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
        Schema::create('energy_data', function (Blueprint $table) {

            $table->id();

            $table->foreignId('panel_id')
                ->constrained()
                ->onDelete('cascade');

            $table->decimal('voltage', 8, 2)->default(0);

            $table->decimal('current', 8, 2)->default(0);

            $table->decimal('power', 10, 2)->default(0);

            $table->decimal('energy_kwh', 12, 4)->default(0);

            // NEW AI FIELDS
            $table->float('temperature')->nullable();

            $table->string('weather_condition')->nullable();

            $table->float('efficiency')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('energy_data');
    }
};