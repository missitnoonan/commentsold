<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use mysql_xdevapi\Exception;

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
        $user_id,
        $page = 1,
        $limit = 20,
        $sort = null,
        $sort_direction = 'desc'
    ): array
    {
        $product = new Product();
        $query = $product->newQuery();

        return $this->getList($query, $page, $limit, $sort, $sort_direction);
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
        $user_id = auth()->user()->id;
        return $query->where('admin_id', $user_id);
    }

    protected function specifySelectForList(Builder $query): Builder
    {
        return $query->select(['id', 'product_name', 'style', 'brand']);
    }
}
