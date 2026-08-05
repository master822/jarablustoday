<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            // إذا كان الجدول يحوي عمود message وليس content
            if (Schema::hasColumn('messages', 'message') && !Schema::hasColumn('messages', 'content')) {
                $table->text('content')->nullable();
            }
            // إذا كان الجدول يحوي content وليس message
            if (Schema::hasColumn('messages', 'content') && !Schema::hasColumn('messages', 'message')) {
                $table->text('message')->nullable();
            }
            // إذا لم يكن أي منهما موجوداً، نضيف الاثنين للاحتياط
            if (!Schema::hasColumn('messages', 'content') && !Schema::hasColumn('messages', 'message')) {
                $table->text('message')->nullable();
                $table->text('content')->nullable();
            }
        });
    }

    public function down(): void
    {
        // لا نحتاج لحذف أعمدة الرسائل تجنباً لفقدان البيانات
    }
};
