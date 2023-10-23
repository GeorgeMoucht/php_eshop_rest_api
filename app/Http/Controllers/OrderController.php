<?php

namespace App\Http\Controllers;

use App\Enums\ACL\Permissions\PermissionName;
use App\Http\Requests\OrderCreateRequest;
use Illuminate\Http\JsonResponse;
use App\Services\OrderService;

class OrderController extends ApiController
{
    //
    public function __construct(OrderService $order)
    {
        $this->middleware('auth');
        $this->order = $order;
    }

    /**
     * Create order based on authenticated customer_id
     * @param OrderCreateRequest $request
     * @return JsonResponse
     */
    public function store(OrderCreateRequest $request): JsonResponse
    {
        // Check if user don't have the permission for this request.
        abort_if_cannot(PermissionName::POST_ORDER->value, true);

        // Create the order
        if($this->order->create($request->all())) {
            return $this->apiResponse(
                payload: ['message' => "Order created."],
                status: 1000,
                method: __METHOD__
            );
        }

        return $this->apiErrorResponse(
            payload: ['message' => "Can't create order. Something went wrong."],
            status: 404,
            method: __METHOD__,
            httpStatusCode: 404
        );
    }
}
