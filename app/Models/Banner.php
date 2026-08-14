<?php

namespace App\Models;

use App\Models\Image;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'type',
        'title',
        'occasion',
        'start_date',
        'end_date',
        'offer_type',
        'offer_value',
        'slug',
        'status',
    ];
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'status' => 'boolean',
    ];
    public function images()
    {
        return $this->hasMany(Image::class, 'banner_id', 'id');
    }
}
