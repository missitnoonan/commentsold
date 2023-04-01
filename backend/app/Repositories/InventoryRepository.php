<?php

namespace App\Repositories;

use App\Interfaces\InventoryRepositoryInterface;
use App\Models\Inventory;

class InventoryRepository implements InventoryRepositoryInterface
{
    public function load(array $inventory_data): bool {
        try {
            Inventory::insert($inventory_data);

            return true;
        } catch (\Exception $exception) {
            // TODO something better

            return false;
        }
    }
}
