<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('services', function (Blueprint $table) {
            // إضافة user_id إذا لم يكن موجوداً
            if (!Schema::hasColumn('services', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('id')->constrained()->onDelete('cascade');
            }
            // إضافة أعمدة أخرى إذا كانت مفقودة
            if (!Schema::hasColumn('services', 'service_name')) {
                $table->string('service_name')->nullable();
            }
            if (!Schema::hasColumn('services', 'city')) {
                $table->string('city')->nullable();
            }
            if (!Schema::hasColumn('services', 'is_active')) {
                $table->boolean('is_active')->default(true);
            }
        });
    }

    public function down()
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
