<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\Category;
use App\Models\Product;


class Subcategory extends Model
{
    use HasFactory;

    protected $table = 'subcategories';

    protected $fillable = [
        'category_id',
        'subcategory_name',
        'subcategory_title',
        'subcategory_description',
        'subcategory_slug',
        'subcategory_status',
    ];

    // Subcategory belongs to Category
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    // Subcategory has many Products
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'subcategory_id', 'id');
    }
}
