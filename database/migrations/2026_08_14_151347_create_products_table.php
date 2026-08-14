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

            // User reference - product owner
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            // Categorization
            $table->foreignId('category_id')
                ->constrained('categories')
                ->cascadeOnDelete();

            $table->foreignId('subcategory_id')
                ->nullable()
                ->constrained('subcategories')
                ->nullOnDelete();

            $table->foreignId('brand_id')
                ->nullable()
                ->constrained('brands')
                ->cascadeOnDelete();

            $table->foreignId('product_model_id')
                ->nullable()
                ->constrained('product_models')
                ->nullOnDelete();


            // Basic Info
            $table->string('name');
            $table->text('short_description')->nullable();
            $table->longText('full_description')->nullable();

            // Inventory
            $table->string('slug')->unique();

            // Status & Visibility
            $table->integer('status')->default(1); // 1 = active, 0 = inactive
            $table->enum('visibility', ['visible', 'hidden'])->default('visible');
            $table->boolean('featured')->default(false);

            // Specifications
            $table->decimal('product_weight', 8, 3)->nullable();
            $table->string('warranty', 100)->nullable();

            // SEO
            $table->string('meta_title', 255)->nullable();
            $table->string('meta_description', 500)->nullable();
            $table->string('meta_keywords', 255)->nullable();

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
