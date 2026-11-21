
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('checkouts', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('name', 100);
            $table->string('phone', 20);

            $table->string('country', 2)->default('BD');

            $table->unsignedBigInteger('division');
            $table->unsignedBigInteger('district');
            $table->unsignedBigInteger('thana');

            $table->string('area', 100);
            $table->string('postal_code', 10);
            $table->string('street_address', 255);

            $table->timestamps();

            $table->index('user_id');
            $table->index(['division', 'district', 'thana']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('checkouts');
    }
};
