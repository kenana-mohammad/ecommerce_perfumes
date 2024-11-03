<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->decimal('discount_percent', 5, 2)->default(0); // نسبة الخصم (مثلاً 10%)
            $table->decimal('discount_amount', 10, 2)->nullable(); // قيمة الخصم الثابتة (مثلاً 50)
            $table->date(column: 'expires_at')->nullable(); // تاريخ انتهاء صلاحية الكود            $table->timestamps();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
