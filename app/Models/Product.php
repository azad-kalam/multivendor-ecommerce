<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\User;
use App\Models\Subcategory;
use App\Models\Price;
use App\Models\Image;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'user_id',
        'name',
        'short_description',
        'full_description',
        'slug',
        'sku',
        'subcategory_id',
        'visibility',
        'status',
        'featured',
        'stock_quantity',
        'stock_status',
        'manage_stock',
        'brand',
        'model',
        'color',
        'size',
        'product_weight',
        'warranty',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    /**
     * Product belongs to User (owner).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Product belongs to Subcategory.
     */
    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class, 'subcategory_id', 'id');
    }

    /**
     * Product has one Price.
     */
    public function price(): HasOne
    {
        return $this->hasOne(Price::class, 'product_id', 'id');
    }

    /**
     * Product has many Images.
     */
    public function images(): HasMany
    {
        return $this->hasMany(Image::class, 'product_id', 'id');
    }
}
