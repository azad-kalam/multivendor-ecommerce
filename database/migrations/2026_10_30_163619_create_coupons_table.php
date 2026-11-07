
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
            $table->string('coupon_code', 30)->unique();
            $table->string('coupon_name', 100)->nullable();
           $table->string('description', 100)->nullable();
            $table->enum('discount_type', ['fixed', 'percentage'])->default('fixed');
            $table->decimal('discount_value', 10, 2);
            $table->unsignedInteger('min_quantity')->nullable();
            $table->unsignedInteger('max_quantity')->nullable();
            $table->decimal('min_cart_value', 10, 2)->default(0);
            $table->decimal('max_cart_value', 10, 2)->nullable();
            $table->unsignedInteger('usage_limit_per_user')->nullable(); //একজন user একটি coupon মোট কতবার ব্যবহার করতে পারবে
            $table->unsignedInteger('total_usage_limit')->nullable(); //all user রা মোট কতবার coupon ব্যবহার করা যাবে
            $table->unsignedInteger('used_count')->default(0); // কোন একটি Coupon এখন পর্যন্ত all user মিলে মোট কতবার ব্যবহার করেছে
            $table->tinyInteger('status')->default(1);
            $table->date('expire_at')->nullable();

            $table->timestamps();
            $table->index(['status', 'expire_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
