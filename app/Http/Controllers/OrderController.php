<?php

namespace App\Http\Controllers;

use App\Enums\ACL\Permissions\PermissionName;
use App\Http\Requests\OrderCreateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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

    /**
     * Retrieve all orders from authenticated customer.
     * @return JsonResponse
     */
    public function showAuthenticated(): JsonResponse
    {
        abort_if_cannot(PermissionName::GET_ORDER->value, true);

        $orders = $this->order->showAuthenticated();

        if(!empty($orders))
        {
            $ordersCount = count($orders);
            return $this->apiResponse(
                payload: [
                    "All orders" => $ordersCount,
                    "orders" => $orders
                ],
                status: 1000,
                method: __METHOD__,
            );
        }

        return $this->apiResponse(
            payload: [
                "message" => "This customer doesn't have active order",
                "orders" => $orders
            ],
            status: 404,
            method: __METHOD__,
            httpStatusCode: 404

        );
    }

    /**
     * Return specific order list based on given customer_id.
     * @param Int $customer_id
     * @return JsonResponse
     */
    public function showSpecific(Int $customer_id): JsonResponse
    {
        abort_if_cannot(PermissionName::GET_SPECIFIC_ORDER->value, true);

        $orders = $this->order->showSpecific($customer_id);

        if(!empty($orders))
        {
            $ordersCount = count($orders);
            return $this->apiResponse(
                payload: [
                    "All orders" => $ordersCount,
                    "orders" => $orders
                ],
                status: 1000,
                method: __METHOD__,
            );
        }

        return $this->apiResponse(
            payload: [
                "message" => "This customer doesn't have active order",
                "orders" => $orders
            ],
            status: 404,
            method: __METHOD__,
            httpStatusCode: 404
        );
    }

    /**
     * Update specific order based on customer_id.
     * @param array $data
     * @param Int $customer_id
     * @return JsonResponse
     */
    public function updateSpecific(Request $request, Int $order_id): JsonResponse
    {
//        dd($data);
        abort_if_cannot(PermissionName::PUT_SPECIFIC_ORDER->value, true);

        $order = $this->order->updateSpecific($request->all(), $order_id);

        if(!empty($order)) {
            return $this->apiResponse(
                payload: [
                    "message" => "Order updated",
                    "orders" => $order
                ],
                status: 1000,
                method: __METHOD__,
            );
        }

        return $this->apiResponse(
            payload: [
                "message" => "Order not found."
            ],
            status: 404,
            method: __METHOD__,
            httpStatusCode: 404
        );
    }
}
