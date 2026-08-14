<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\ProductVariant;

class Size extends Model
{
    protected $table = 'sizes';

    protected $fillable = [
        'name',
        'status'
    ];

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class, 'size_id', 'id');
    }
}
