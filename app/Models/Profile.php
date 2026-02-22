<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\User;
use App\Models\Image;


class Profile extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'about',
        'company',
        'job',
        'country',
        'address',
        'twitter',
        'facebook',
        'instagram',
        'linkedin',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function image()
    {
        return $this->hasOne(Image::class, 'profile_id', 'id');
    }
}
