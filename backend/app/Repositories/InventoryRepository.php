<?php

namespace App\Repositories;

use App\Interfaces\InventoryRepositoryInterface;
use App\Models\Inventory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

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
        $sort_direction = 'desc',
        $search = '',
    ): array
    {
        $inventory = new Inventory();
        $query = $inventory->newQuery();

        return $this->getList($query, $page, $limit, $sort, $sort_direction, $search);
    }

    public function find($inventory_id): array
    {
        try {
            $inventory_item = Inventory::with('product')->findOrFail($inventory_id);

            return $inventory_item->toArray();
        } catch (\Exception $exception) {
            // TODO: Handle Exceptions
        }
    }

    public function stats(): array
    {
        $query = Inventory::query();
        $query = $this->addAuthorization($query);

        $sku_count = $query->count();
        $total_items = $query->sum('quantity');

        return [
            'sku_count' => $sku_count,
            'total_items' => (int) $total_items,
        ];
    }

    protected function addAuthorization(Builder $query): Builder
    {
        return $query
            ->join('products', 'inventories.product_id', 'products.id')
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
            DB::raw('inventories.price_cents * inventories.quantity as potential_revenue'),
            'products.admin_id',
            'products.id as product_id',
        ]);
    }

    // this is inefficient, but works to show search
    protected function addSearch(Builder $query, $search): Builder {
        if ($search) {
            return $query->where(function ($query) use ($search) {
                $query->where('inventories.sku', 'LIKE', "%$search%")
                    ->orWhere('products.product_name', 'LIKE', "%$search%");
            });
        }

        return $query;
    }
}
