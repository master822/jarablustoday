<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->after('id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('sender_id')
                ->nullable()
                ->after('user_id')
                ->constrained('users')
                ->nullOnDelete();

            $table->string('type')->after('sender_id');
            $table->string('title')->after('type');
            $table->text('message')->after('title');
            $table->string('link')->nullable()->after('message');
            $table->boolean('is_read')->default(false)->after('link');

            $table->index(['user_id', 'is_read']);
            $table->index(['type', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['sender_id']);

            $table->dropIndex(['user_id', 'is_read']);
            $table->dropIndex(['type', 'created_at']);

            $table->dropColumn([
                'user_id',
                'sender_id',
                'type',
                'title',
                'message',
                'link',
                'is_read',
            ]);
        });
    }
};