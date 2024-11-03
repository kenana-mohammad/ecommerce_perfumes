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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText(column: 'description')->nullable();
            $table->integer('volume')->default(50); 
            $table->float('old_price')->nullable();
            $table->float('current_price');
            $table->integer('quantity')->default(0);
            $table->string('image');
            $table->json('ingredients')->nullable(); // لتخزين المكونات كقائمة
            $table->json('specifications')->nullable(); // لتخزين المواصفات كقائمة
            $table->json('features')->nullable(); // لتخزين المميزات كقائمة
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('products')->onDelete('set null'); // بديل للعطر
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
