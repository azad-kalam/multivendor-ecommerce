<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Banner;
use App\Models\Profile;
use App\Models\ProductVariant;


class Image extends Model
{
    use HasFactory;

    protected $table = 'images';

    protected $fillable = [
        'product_id',
        'product_variant_id',
        'banner_id',
        'brand_id',
        'profile_id',
        'file_name',
        'upload_folder',
        'public_path',
        'file_hash',
        'video_url',
        'alt_text',
    ];

    public function banner()
    {
        return $this->belongsTo(Banner::class, 'banner_id', 'id');
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class, 'profile_id', 'id');
    }


    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id', 'id');
    }
}
