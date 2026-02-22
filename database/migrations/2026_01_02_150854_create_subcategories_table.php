<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subcategories', function (Blueprint $table) {
            $table->id();

            // Foreign key to categories table
            $table->foreignId('category_id')
                ->constrained()
                ->onDelete('cascade');

            // Subcategory-specific fields
            $table->string('subcategory_name');
            $table->string('subcategory_title')->nullable();
            $table->text('subcategory_description')->nullable();
            $table->string('subcategory_slug')->unique();
            $table->enum('subcategory_status', ['active', 'inactive'])->default('active');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subcategories');
    }
};
