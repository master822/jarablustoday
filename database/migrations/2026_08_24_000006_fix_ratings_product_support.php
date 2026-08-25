<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('ratings', 'product_id')) {
            Schema::table('ratings', function (Blueprint $table) {
                $table->foreignId('product_id')
                    ->nullable()
                    ->after('merchant_id')
                    ->constrained()
                    ->nullOnDelete();

                $table->index(['product_id', 'is_approved']);
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('ratings', 'product_id')) {
            Schema::table('ratings', function (Blueprint $table) {
                $table->dropForeign(['product_id']);
                $table->dropIndex(['product_id', 'is_approved']);
                $table->dropColumn('product_id');
            });
        }
    }
};
