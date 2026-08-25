<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->enum('type', ['sale', 'rent']);

            $table->string('title');
            $table->text('description');

            $table->decimal('price', 15, 2);
            $table->string('city')->nullable();
            $table->string('area')->nullable();
            $table->string('address')->nullable();

            $table->unsignedInteger('rooms')->nullable();
            $table->unsignedInteger('bathrooms')->nullable();
            $table->unsignedInteger('area_m2')->nullable();

            $table->json('images')->nullable();

            $table->enum('status', ['pending', 'approved', 'rejected'])
                ->default('pending');

            $table->text('rejection_reason')->nullable();
            $table->timestamp('approved_at')->nullable();

            $table->timestamps();

            $table->index(['type', 'status']);
            $table->index(['city', 'type']);
            $table->index(['status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
