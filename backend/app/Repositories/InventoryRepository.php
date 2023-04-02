<?php

namespace App\Repositories;

use App\Interfaces\InventoryRepositoryInterface;
use App\Models\Inventory;
use Illuminate\Database\Eloquent\Builder;

class InventoryRepository extends AbstractRepository implements InventoryRepositoryInterface
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

    public function list(
        $page = 1,
        $limit = 20,
        $sort = null,
        $sort_direction = 'desc'
    ): array
    {
        $inventory = new Inventory();
        $query = $inventory->newQuery();

        return $this->getList($query, $page, $limit, $sort, $sort_direction);
    }

    public function find($inventory_id): array
    {
        return [];
    }

    protected function addAuthorization(Builder $query): Builder
    {
        return $query
            ->rightJoin('products', 'inventories.product_id', 'products.id')
            ->where('products.admin_id', auth()->user()->id);
    }

    protected function specifySelectForList(Builder $query): Builder
    {
        return $query->select([
            'inventories.id',
            'products.product_name',
            'inventories.sku',
            'inventories.quantity',
            'inventories.color',
            'inventories.size',
            'inventories.price_cents',
            'inventories.cost_cents',
            'products.admin_id',
            'products.id as product_id',
        ]);
    }
}
