<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // اسم المنتج
            $table->text('description')->nullable(); // الوصف (nullable باش ما يوقعش خطأ إلا كان خاوي)
            $table->integer('quantity'); // الكمية
            $table->decimal('price', 8, 2); // الثمن
            $table->integer('min_stock')->default(5); // الحد الأدنى للتنبيه
            
            // الربط الأساسي (La Relation) بين السلعة والصنف
            $table->foreignId('category_id')
                  ->constrained('categories')
                  ->onDelete('cascade'); // إلا تمسح الصنف كيتمسحوا منتجاته
                  
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('products');
    }
};