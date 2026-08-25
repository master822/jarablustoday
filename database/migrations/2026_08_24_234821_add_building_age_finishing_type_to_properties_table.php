<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            if (!Schema::hasColumn('properties', 'building_age')) {
                $table->unsignedInteger('building_age')->nullable()->after('area_m2');
            }

            if (!Schema::hasColumn('properties', 'finishing_type')) {
                $table->string('finishing_type')->nullable()->after('building_age');
            }
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            if (Schema::hasColumn('properties', 'finishing_type')) {
                $table->dropColumn('finishing_type');
            }

            if (Schema::hasColumn('properties', 'building_age')) {
                $table->dropColumn('building_age');
            }
        });
    }
};
