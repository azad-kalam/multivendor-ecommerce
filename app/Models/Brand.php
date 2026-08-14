<?php

namespace App\Models;

use App\Models\Product;
use App\Models\Image;
use App\Models\ProductModel;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = 'brands';
    protected $fillable = [
        'name',
        'slug',
        'status'
    ];

    public function productModels(): HasMany
    {
        return $this->hasMany(ProductModel::class, 'brand_id', 'id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(Image::class, 'brand_id', 'id');
    }
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'brand_id', 'id');
    }
}
