<?php

namespace App\Interfaces;

interface ProductRepositoryInterface
{
    public function load(array $product_data): bool;

    public function list($user_id, $page, $limit, $sort = null, $sort_direction = 'DESC'): array;

    public function find($product_id): array;
}
