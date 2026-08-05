<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('subscriptions')) {
            Schema::create('subscriptions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('plan');
                $table->integer('product_limit');
                $table->date('start_date');
                $table->date('end_date');
                $table->string('status')->default('pending');
                $table->text('payment_proof')->nullable();
                $table->timestamp('payment_proof_sent_at')->nullable();
                $table->timestamp('activated_at')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};