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
{
    Schema::create('energy_data', function (Blueprint $table) {
        $table->id();
        $table->foreignId('panel_id')->constrained()->onDelete('cascade');
        $table->decimal('power', 8, 2);
        $table->decimal('consumption', 8, 2); 
        $table->integer('voltage');
        $table->integer('current');
        $table->decimal('energy_kwh', 10, 4);
        $table->timestamps();
    });
}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('energy_data');
    }
};