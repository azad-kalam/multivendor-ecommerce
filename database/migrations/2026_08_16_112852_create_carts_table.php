<?php

// use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;

// return new class extends Migration
// {
//     public function up(): void
//     {
//         Schema::create('carts', function (Blueprint $table) {
//             $table->id();

//             $table->string('session_id')->nullable();

//             $table->foreignId('user_id')
//                 ->nullable()
//                 ->constrained()
//                 ->nullOnDelete();

//             $table->foreignId('product_id')
//                 ->constrained()
//                 ->cascadeOnDelete();

//             $table->foreignId('product_variant_id')
//                 ->constrained('product_variants')
//                 ->cascadeOnDelete();

//             $table->string('product_size');
//             $table->unsignedInteger('product_quantity')->default(1);

//             $table->timestamps();
//         });
//     }

//     public function down(): void
//     {
//         Schema::dropIfExists('carts');
//     }
// };




use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {

            $table->id();

            $table->string('session_id')
                ->nullable()
                ->index();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('product_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('product_variant_id')
                ->constrained('product_variants')
                ->cascadeOnDelete();

            $table->unsignedInteger('product_quantity')
                ->default(1);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
