<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->unique(); // رقم الهاتف فريد لكل مستخدم
            $table->string('password');
            $table->enum('role', ['admin', 'driver', 'vendor'])->default('vendor'); // تحديد نوع المستخدم
            $table->boolean('is_approved')->default(false); // حالة الموافقة
            $table->timestamp('last_login_at')->nullable(); // آخر تسجيل دخول
            $table->decimal('wallet_balance', 10, 2)->default(0); // رصيد المحفظة
            $table->rememberToken(); // للتعامل مع الجلسات إن احتجت
            $table->timestamps(); // created_at و updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
