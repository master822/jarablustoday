<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('services')) {
            Schema::create('services', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('service_type');
                $table->string('service_name');
                $table->text('description')->nullable();
                $table->string('city')->nullable();
                $table->string('phone')->nullable();
                $table->string('price_type')->nullable();
                $table->decimal('price', 10, 2)->nullable();
                $table->boolean('is_active')->default(true);
                $table->text('images')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};