<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('session_id')
                ->nullable()
                ->index();

            $table->foreignId('product_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('product_variant_id')
                ->constrained('product_variants')
                ->cascadeOnDelete();

            $table->unsignedInteger('product_quantity')
                ->default(1);

            $table->timestamps();

            $table->unique(
                ['user_id', 'product_variant_id'],
                'unique_user_cart_variant'
            );

            $table->unique(
                ['session_id', 'product_variant_id'],
                'carts_session_variant_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
