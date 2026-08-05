<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // SQLite لا يدعم تعديل الأعمدة مباشرة عبر change() بسهولة بدون حزم خارجية،
        // لذا سنقوم بإعادة إنشاء الجدول أو جعله آمنًا بإضافة قيمة افتراضية للعمود لمنع خطأ NOT NULL
        Schema::table('messages', function (Blueprint $table) {
            if (Schema::hasColumn('messages', 'content')) {
                $table->text('content')->nullable()->default('')->change();
            }
        });
    }

    public function down(): void
    {
        // لا شيء مطلوب في التراجع
    }
};
