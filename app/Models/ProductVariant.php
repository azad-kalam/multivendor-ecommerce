<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\Product;
use App\Models\Cart;
use App\Models\Color;
use App\Models\Size;
use App\Models\Image;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;
    protected $table = 'product_variants';
    protected $fillable = [
        'product_id',
        'color_id',
        'size_id',
        'regular_price',
        'selling_price',
        'discount_value',
        'discount_type',
        'discount_start',
        'discount_end',
        'sku',
        'stock_quantity',
        'stock_status',
        'manage_stock',
    ];

    protected $casts = [
        'discount_start' => 'datetime',
        'discount_end'   => 'datetime',
    ];


    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class, 'product_variant_id', 'id');
    }

    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class, 'color_id', 'id');
    }

    public function size(): BelongsTo
    {
        return $this->belongsTo(Size::class, 'size_id', 'id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(Image::class, 'product_variant_id', 'id');
    }
}
