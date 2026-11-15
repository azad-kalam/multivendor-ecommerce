<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Checkout extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'country',
        'division',
        'district',
        'thana',
        'area',
        'postal_code',
        'street_address',
    ];

    protected function casts(): array
    {
        return [
            'division' => 'integer',
            'district' => 'integer',
            'thana' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function order(): HasOne
    {
        return $this->hasOne(Order::class, 'checkout_id', 'id');
    }
}
