<?php

// namespace App\Models;

// use App\Models\User;
// use App\Models\Product;
// use App\Models\ProductVariant;

// use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Relations\BelongsTo;

// class Cart extends Model
// {
//     protected $fillable = [
//         'session_id',
//         'user_id',
//         'product_id',
//         'product_variant_id',
//         'product_size',
//         'product_quantity',
//     ];

//     public function user(): BelongsTo
//     {
//         return $this->belongsTo(User::class, 'user_id', 'id');
//     }

//     public function product(): BelongsTo
//     {
//         return $this->belongsTo(Product::class, 'product_id', 'id');
//     }

//     public function variant(): BelongsTo
//     {
//         return $this->belongsTo(ProductVariant::class, 'product_variant_id', 'id');
//     }
// }




namespace App\Models;

use App\Models\User;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    protected $fillable = [
        'session_id',
        'user_id',
        'product_id',
        'product_variant_id',
        'product_size',
        'product_color',
        'product_quantity',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'user_id',
            'id'
        );
    }


    public function product(): BelongsTo
    {
        return $this->belongsTo(
            Product::class,
            'product_id',
            'id'
        );
    }


    public function variant(): BelongsTo
    {
        return $this->belongsTo(
            ProductVariant::class,
            'product_variant_id',
            'id'
        );
    }
}
