<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    // protected $fillable = [
    //     'coupon_name',
    //     'description',
    //     'coupon_code',
    //     'discount_type',
    //     'discount_value',
    //     'min_quantity',
    //     'max_quantity',
    //     'min_cart_value',
    //     'max_cart_value',
    //     'usage_limit_per_user',
    //     'total_usage_limit',
    //     'used_count',
    //     'expire_at',
    //     'status',
    // ];
    protected $fillable = [
        'coupon_options',
        'coupon_type',
        'user_id',
        'coupon_name',
        'description',
        'coupon_code',
        'discount_type',
        'discount_value',
        'min_quantity',
        'max_quantity',
        'min_cart_value',
        'max_cart_value',
        'usage_limit_per_user',
        'total_usage_limit',
        'used_count',
        'expire_at',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'discount_value' => 'decimal:2',
            'min_quantity' => 'integer',
            'max_quantity' => 'integer',
            'min_cart_value' => 'decimal:2',
            'max_cart_value' => 'decimal:2',
            'coupon_used' => 'integer',
            'usage_limit_per_user' => 'integer',
            'total_usage_limit' => 'integer',
            'used_count' => 'integer',
            'expire_at' => 'date',
            'status' => 'boolean',
        ];
    }
}
