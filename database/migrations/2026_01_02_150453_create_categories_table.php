<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();              // Required and unique
            $table->string('title')->nullable();           // Optional display title
            $table->text('description')->nullable();       // Use text for better length
            $table->string('slug')->unique();              // For SEO URLs
            $table->enum('status', ['active', 'inactive'])->default('active'); // Controlled values
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};