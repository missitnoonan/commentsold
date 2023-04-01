<?php

namespace App\Interfaces;

interface OrderRepositoryInterface
{
    public function load(array $order_data);
}
