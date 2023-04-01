<?php

namespace App\Repositories;

use App\Interfaces\OrderRepositoryInterface;
use App\Models\Order;

class OrderRepository implements OrderRepositoryInterface
{
    public function load(array $order_data) {
        try {
            Order::insert($order_data);

            return true;
        } catch (\Exception $exception) {

            return false;
        }
    }
}
