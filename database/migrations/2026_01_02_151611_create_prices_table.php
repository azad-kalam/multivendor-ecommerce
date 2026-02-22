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
        Schema::create('prices', function (Blueprint $table) {
            $table->id();

            // Foreign key linking to product, cascade on delete
            $table->foreignId('product_id')->constrained()->onDelete('cascade');

            // Price fields
            $table->decimal('regular_price', 10, 2);
            $table->decimal('selling_price', 10, 2);

            // Discount details
            $table->decimal('discount_value', 10, 2)->nullable();
            $table->enum('discount_type', ['none', 'flat', 'percent'])->default('none');
            $table->dateTime('discount_start')->nullable();
            $table->dateTime('discount_end')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prices');
    }
};
