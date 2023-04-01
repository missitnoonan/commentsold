<?php

namespace App\Interfaces;

interface InventoryRepositoryInterface
{
    public function load(array $inventory_data);

    public function list($page, $limit, $sort = null, $sort_direction = 'DESC'): array;

    public function find($inventory_id): array;
}
