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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')
                ->constrained('products')
                ->cascadeOnDelete();

            $table->foreignId('color_id')
                ->constrained('colors')
                ->restrictOnDelete();

            $table->foreignId('size_id')
                ->constrained('sizes')
                ->restrictOnDelete();

            $table->decimal('regular_price', 10, 2)->nullable();
            $table->decimal('selling_price', 10, 2)->nullable();

            $table->enum('discount_type', ['none', 'fixed', 'percent'])->default('none');
            $table->decimal('discount_value', 10, 2)->nullable();
            $table->dateTime('discount_start')->nullable();
            $table->dateTime('discount_end')->nullable();

            $table->string('sku', 100)->nullable()->unique();
            $table->unsignedInteger('stock_quantity')->default(0);
            $table->enum('stock_status', ['in_stock', 'out_of_stock'])->default('in_stock');
            $table->boolean('manage_stock')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
