<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\ProductVariant;

class Color extends Model
{
    protected $table = 'colors';

    protected $fillable = [
        'name',
        'code',
        'status'
    ];

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class, 'color_id', 'id');
    }
}
