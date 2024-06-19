<?php

namespace App\Services;

use App\Enums\ACL\Orders\Status;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;

class OrderService
{
    protected CustomerService $customer;
    protected OrderDetailsService $orderDetails;

    public function __construct(CustomerService $customer)
    {
        $this->customer = $customer;
    }
    public function create(array $data)
    {
        // 1. Create the order and fill comments if needed.
        $customerId = $this->customer->getAuthCustomerId();

        if(!$customerId) {
            return false;
        }

        // Fill customer_id
        $order = Order::create([
            'comments' => $data['comments'],
            'order_date' => now(),
            'status' => Status::PENDING->value,
            'customer_id' => $this->customer->getAuthCustomerId()
        ]);

        $orderLineNumber = 1;
        // 2. for every element in order array, create order_details row. Fill product_id and quantity_ordered.
        foreach($data['order'] as $item) {
            $product = Product::find($item['product_id']);
            if(!$product) {
                return false;
            }
            // Init buy_price as product msrp.
            $priceEach = $product->msrp;
            OrderDetails::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity_ordered' => $item['quantity_ordered'],
                'price_each' => $priceEach,
                'order_line_number' => $orderLineNumber
            ]);
            $orderLineNumber++;
        }
        return $order;
    }

    /**
     * @return array
     */
    public function showAuthenticated()
    {
        $customer_id = $this->customer->getAuthCustomerId();
        if($customer_id)
        {
            $orders = Order::where('customer_id', $customer_id)->get();

            foreach($orders as $order) {
                $orderDetailsAttributes = [
                    'product_id',
                    'quantity_ordered',
                    'price_each',
                    'order_line_number'
                ];
                $order->orderDetails = OrderDetails::where('order_id', $order->id)
                    ->select($orderDetailsAttributes)->get();
            }
            return $orders;
        }
        return [];
    }

    /**
     * Return order list based on given $customer_id.
     * @param Int $customer_id
     * @return array
     */
    public function showSpecific(Int $customer_id)
    {
        if($customer_id)
        {
            $orders = Order::where('customer_id', $customer_id)->get();

            foreach($orders as $order) {
                $orderDetailsAttributes = [
                    'product_id',
                    'quantity_ordered',
                    'price_each',
                    'order_line_number'
                ];
                $order->orderDetails = OrderDetails::where('order_id', $order->id)
                    ->select($orderDetailsAttributes)->get();
            }
            return $orders;
        }
        return [];
    }

    /**
     *
     * Update specific order based on customer_id.
     * @param array $data
     * @param Int $customer_id
     * @return bool|int
     */
    public function updateSpecific(array $data, Int $order_id): bool|int
    {
        $order = Order::where('id', $order_id)->first();

        if(!$order)
        {
            return false;
        }
        return $order->update($data);
    }


}
