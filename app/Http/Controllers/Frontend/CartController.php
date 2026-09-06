<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Http\Requests\FrontEnd\CartRequest;
use App\Services\FrontEnd\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class CartController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }


    public function index()
    {
        $get_cart = $this->cartService->index_cart();
        return view('frontend.carts.index', [
            'cart_items' => $get_cart['items'],
            'subtotal' => $get_cart['subtotal'],
            'discount' => $get_cart['discount'],
            'grand_total' => $get_cart['grand_total'],
        ]);
    }

    public function store(CartRequest $request)
    {
        $validated_data = $request->validated();
        $result_data = $this->cartService->addToCart($validated_data);
        return response()->json($result_data);
    }
}
