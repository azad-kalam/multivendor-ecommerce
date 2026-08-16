<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Http\Requests\FrontEnd\CartRequest;
use App\Services\FrontEnd\CartService;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    protected CartService $cart_service;

    public function __construct(CartService $service)
    {
        $this->cart_service = $service;
    }

    public function store(CartRequest $request): JsonResponse
    {
        $result = $this->cart_service->addToCart(
            $request->validated()
        );

        if (!$result['status']) {

            return response()->json(
                [
                    'cart_status' => 'error',
                    ...$result,
                ],
                422
            );
        }

        return response()->json(
            [
                'cart_status' => 'success',
                ...$result,
            ],
            200
        );
    }
}
