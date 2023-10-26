<?php

namespace App\Services;

use App\Enums\ACL\Orders\Status;
use App\Models\Order;

class OrderService
{

    public function __construct()
    {

    }

    public function create(array $data)
    {
        dd($data);
        if(!me()->customer) {
            return null;
        }



        $order = new Order();
        $order->customer_id = getCustomerId();
        $order->order_date = now();
        $order->status = Status::PENDING->value;
        $order->fill($data);


        // TODO For each product in $data array. Fill order_details table.

        if($order->save()) {

//            return $order->save();
        }
        return false;
    }

}
