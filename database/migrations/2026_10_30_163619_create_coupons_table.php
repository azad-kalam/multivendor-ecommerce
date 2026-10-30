
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->enum('coupon_option', ['manual', 'automatic'])->default('automatic');
            $table->string('coupon_code', 50)->unique();
            $table->enum('coupon_type', ['single', 'multiple'])->default('single');
            $table->enum('discount_type', ['fixed', 'percentage'])->default('fixed');
            $table->decimal('discount_value', 5, 2);
            $table->unsignedInteger('min_quantity')->nullable();
            $table->unsignedInteger('max_quantity')->nullable();
            $table->decimal('min_cart_value', 5, 2)->default(0);
            $table->decimal('max_cart_value', 5, 2)->nullable();
            $table->unsignedInteger('coupon_used')->default(0);
            $table->unsignedInteger('usage_limit_per_user')->nullable();
            $table->unsignedInteger('total_usage_limit')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->date('start_at')->nullable();
            $table->date('expire_at')->nullable();

            $table->timestamps();
            $table->index(['status', 'start_at', 'expire_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
