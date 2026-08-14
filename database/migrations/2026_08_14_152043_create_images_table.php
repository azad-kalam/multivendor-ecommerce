<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// return new class extends Migration {
//     public function up(): void
//     {
//         Schema::create('images', function (Blueprint $table) {
//             $table->id();
//             $table->foreignId('product_id')
//                 ->nullable()
//                 ->constrained('products')
//                 ->onDelete('cascade');

//             $table->foreignId('banner_id')
//                 ->nullable()
//                 ->constrained('banners')
//                 ->cascadeOnUpdate()
//                 ->cascadeOnDelete();

//             $table->foreignId('brand_id')
//                 ->nullable()
//                 ->constrained()
//                 ->cascadeOnDelete();

//             $table->foreignId('profile_id')
//                 ->nullable()
//                 ->constrained('profiles')
//                 ->onDelete('cascade');

//             $table->string('file_name');
//             $table->string('upload_folder');
//             $table->string('public_path');

//             $table->string('file_hash', 64);

//             $table->unique(['upload_folder', 'file_hash']);

//             $table->string('video_url')->nullable();
//             $table->string('alt_text')->nullable();

//             $table->timestamps();
//         });
//     }

//     public function down(): void
//     {
//         Schema::dropIfExists('images');
//     }
// };

return new class extends Migration {
    public function up(): void
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')
                ->nullable()
                ->constrained('products')
                ->onDelete('cascade');

            $table->foreignId('product_variant_id')
                ->nullable()
                ->constrained('product_variants')
                ->onDelete('cascade');

            $table->foreignId('banner_id')
                ->nullable()
                ->constrained('banners')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('brand_id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('profile_id')
                ->nullable()
                ->constrained('profiles')
                ->onDelete('cascade');

            $table->string('file_name');
            $table->string('upload_folder');
            $table->string('public_path');

            $table->string('file_hash', 64);

            $table->unique(['upload_folder', 'file_hash']);

            $table->string('video_url')->nullable();
            $table->string('alt_text')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
