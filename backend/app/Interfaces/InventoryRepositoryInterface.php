<?php

namespace App\Interfaces;

interface InventoryRepositoryInterface
{
    public function load(array $inventory_data);
}
