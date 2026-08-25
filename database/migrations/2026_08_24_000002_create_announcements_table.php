<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();

            $table->string('title');
            $table->text('content');
            $table->string('image')->nullable();
            $table->string('phone')->nullable();
            $table->string('city')->nullable();

            $table->enum('status', ['pending', 'approved', 'rejected'])
                ->default('pending');

            $table->text('rejection_reason')->nullable();
            $table->timestamp('approved_at')->nullable();

            $table->timestamps();

            $table->index(['status', 'created_at']);
            $table->index('city');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
