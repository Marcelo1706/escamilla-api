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
        Schema::table('tour_packages', function (Blueprint $table) {
            $table->boolean('flights')->default(false);
            $table->boolean('hotels')->default(false);
            $table->boolean('meals')->default(false);
            $table->boolean('transportation')->default(false);
            $table->boolean('assistance')->default(false);
            $table->boolean('baggage')->default(false);
            $table->boolean('tours')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tour_packages', function (Blueprint $table) {
            $table->dropColumn(['flights', 'hotels', 'meals', 'transportation', 'assistance', 'baggage', 'tours']);
        });
    }
};
