<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\Profile;
use App\Models\Product;

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

    // A User has many Products
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id','id');
    }
}
