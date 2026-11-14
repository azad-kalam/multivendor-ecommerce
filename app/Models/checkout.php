<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use App\Models\Order;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Checkout extends Model
{
    protected $fillable = [
        'order_number',
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

        'payment_method',
        'order_status',
        'payment_status',

        'subtotal',
        'delivery_charge',
        'total',
    ];

    protected function casts(): array
    {
        return [
            'division' => 'integer',
            'district' => 'integer',
            'thana' => 'integer',

            'subtotal' => 'decimal:2',
            'delivery_charge' => 'decimal:2',
            'total' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }




    public function order():HasOne
    {
        return $this->hasOne(Order::class);
    }
}
