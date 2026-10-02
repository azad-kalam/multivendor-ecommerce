<?php

namespace App\Models;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Profile;
use App\Models\EmailNotification;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

/**
 * @property string $role
 * @property string $status
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $password
 * @property \Illuminate\Support\Carbon|null $last_login_time
 * @property string|null $last_ip_address
 */

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'status',
        'last_login_time',
        'last_ip_address'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_time' => 'datetime',
        'password' => 'hashed',
    ];


    // User has many carts
    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class, 'user_id', 'id');
    }

    // User has many Products
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'user_id', 'id');
    }

    // User has one profile
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class, 'user_id', 'id');
    }

    // User has one email notification
    public function emailNotification(): HasOne
    {
        return $this->hasOne(EmailNotification::class, 'user_id', 'id');
    }
}
