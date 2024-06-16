<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Requests\StoreOrderRequest;
use App\Mail\LowIngredientStock;
use App\Models\Ingredient;
use App\Models\Product;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class OrderController extends ApiBaseController
{
    public function __construct(public OrderService $orderService)
    {
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreOrderRequest $request
     * @return JsonResponse
     */
    public function store(StoreOrderRequest $request)
    {
        $productsInOrder = $request->collect('products');

        $createdOrder = $this->orderService->create($productsInOrder);

        // return order;
        return $this->success(
            [
                'meta' => [
                    'message' => "order created!",
                ],
                'order' => $createdOrder,
            ]
        );

    }
}
