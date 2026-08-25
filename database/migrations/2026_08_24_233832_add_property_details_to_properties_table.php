<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->unsignedInteger('building_age')->nullable()->after('area_m2');
            $table->string('finishing_type')->nullable()->after('building_age');
            $table->string('currency', 3)->default('USD')->after('price');
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn([
                'building_age',
                'finishing_type',
                'currency',
            ]);
        });
    }
};
