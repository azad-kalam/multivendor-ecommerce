<?php

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


function cart_item_quantity()
{
    $authenticated = Auth::check();

    if ($authenticated) {

        $user_id = Auth::id();
        $cart = Cart::where('user_id', $user_id)->sum('product_quantity');
        return $cart;
    } else {

        $session_id = Session::get('session_id');
        if (! $session_id) {
            $session_id = Session::getId();
            Session::put('session_id', $session_id);
        }

        $cart = Cart::where('session_id', $session_id)->sum('product_quantity');
        return $cart;
    }
}
