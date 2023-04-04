<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class ProductRepository extends AbstractRepository implements ProductRepositoryInterface
{
    public function load(array $product_data): bool {
        try {
            Product::insert($product_data);

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
        if ($sort) {
            $sort = "products.$sort";
        }
        $product = new Product();
        $query = $product->newQuery()
            ->leftJoin('inventories', 'inventories.product_id', 'products.id');

        return $this->getList($query, $page, $limit, $sort , $sort_direction);
    }

    public function find($product_id): array
    {
        try {
            $product = Product::with('inventories')->findOrFail($product_id);

            return $product->toArray();
        } catch (\Exception $exception) {
            // TODO: Handle Exceptions
        }
    }

    protected function addAuthorization(Builder $query): Builder
    {
        // this isn't ideal and comes from reusing old code, getting the user_id in this way makes testing harder
        $user_id = auth()->user()->id;
        return $query->where('admin_id', $user_id);
    }

    protected function specifySelectForList(Builder $query): Builder
    {
        return $query->select([
            'products.id',
            'products.product_name',
            'products.style',
            'products.brand',
            DB::raw('sum(inventories.price_cents * inventories.quantity) as potential_revenue'),
        ]);
    }

    protected function addGroupBy(Builder $query): Builder {
        return $query->groupBy('products.id');
    }
}
