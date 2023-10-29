<?php

namespace App\Services;

use App\Enums\ACL\Orders\Status;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;

class OrderService
{
    protected CustomerService $customer;

    public function __construct(CustomerService $customer)
    {
        $this->customer = $customer;
    }
    public function create(array $data)
    {
        // 1. Create the order and fill comments if needed.

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

}
