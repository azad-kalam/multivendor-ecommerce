<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // User reference - product owner
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            // Basic Info
            $table->string('name')->unique();
            $table->text('full_description')->nullable();
            $table->string('short_description', 255)->nullable();

            // Categorization
            $table->foreignId('subcategory_id')
                ->constrained()
                ->onDelete('cascade');

            // Inventory
            $table->string('slug')->unique(); // Slug (SEO-friendly URL)
            $table->string('sku')->unique()->nullable();
            $table->integer('stock_quantity')->nullable();
            $table->enum('stock_status', ['in_stock', 'out_of_stock'])->default('in_stock');
            $table->boolean('manage_stock')->default(false);

            // Status & Visibility
            $table->integer('status')->default(1); // 1 = active, 0 = inactive
            $table->enum('visibility', ['visible', 'hidden'])->default('visible');
            $table->boolean('featured')->default(false);

            // Specifications
            $table->string('brand', 100)->nullable();
            $table->string('model', 100)->nullable();
            $table->string('size', 100)->nullable();
            $table->string('color', 100)->nullable();
            $table->decimal('product_weight', 8, 3)->nullable();
            $table->string('warranty', 100)->nullable();

            // SEO
            $table->string('meta_title', 255)->nullable();
            $table->string('meta_description', 500)->nullable();
            $table->string('meta_keywords', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
