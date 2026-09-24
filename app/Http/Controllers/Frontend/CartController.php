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
        return view('frontend.carts.index');
    }


    public function store(CartRequest $request)
    {
        $validatedData = $request->validated();
        $resultData = $this->cartService->create_cart($validatedData);
        return response()->json($resultData);
    }


    public function update(CartRequest $request, int $cartId)
    {
        $validatedData = $request->validated();
        $result = $this->cartService->update_cart($cartId, $validatedData['product_quantity']);

        return response()->json($result);
    }


    public function destroy(int $cartId)
    {
        $this->cartService->delete_cart($cartId);
        return $this->render_cart_and_summary();
    }


    public function render_cart_and_summary()
    {
        $cartData = $this->cartService->index_cart();

        $cartTable = view('frontend.carts.table.cart_table', [
            'cart_items' => $cartData['items'],
        ])->render();

        $cartSummary = view('frontend.carts.AJAX.ajax_cart_summary', [
            'subtotal' => $cartData['subtotal'],
            'product_discount' => $cartData['product_discount'],
            'coupon_discount' => $cartData['coupon_discount'],
            'grand_total' => $cartData['grand_total'],
        ])->render();

        return response()->json([
            'status' => true,
            'message' => 'Cart item deleted successfully.',
            'cartTable' => $cartTable,
            'cartSummary' => $cartSummary,
        ]);
    }
}
