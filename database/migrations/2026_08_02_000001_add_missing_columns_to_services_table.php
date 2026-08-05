<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            if (!Schema::hasColumn('services', 'service_type')) {
                $table->string('service_type')->default('other')->nullable();
            }
            if (!Schema::hasColumn('services', 'service_name')) {
                $table->string('service_name')->nullable();
            }
            if (!Schema::hasColumn('services', 'description')) {
                $table->text('description')->nullable();
            }
            if (!Schema::hasColumn('services', 'city')) {
                $table->string('city')->nullable();
            }
            if (!Schema::hasColumn('services', 'is_active')) {
                $table->boolean('is_active')->default(true);
            }
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $columns = ['service_type', 'service_name', 'description', 'city', 'is_active'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('services', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
