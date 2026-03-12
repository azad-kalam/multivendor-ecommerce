<?php

namespace App\Models;
use App\Models\User;

use Illuminate\Database\Eloquent\Model;

class EmailNotification extends Model
{
    protected $fillable = [
        'user_id',         // User এর সাথে সম্পর্কের জন্য
        'changes_made',    // checkbox
        'new_products',    // checkbox
        'pro_offers'       // checkbox
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
