<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

abstract class AbstractRepository {
    protected function addSearch(Builder $query, $search): Builder
    {
        return $query;
    }

    protected function addAuthorization(Builder $query): Builder
    {
        return $query;
    }

    protected function specifySelectForList(Builder $query): Builder
    {
        return $query;
    }

    protected function addGroupBy(Builder $query): Builder
    {
        return $query;
    }

    public function getList(Builder $query, $page, $limit, $sort = null, $sort_direction = 'DESC', $search = ''): array
    {
        $skip = ($page - 1) * $limit;

        $query = $this->specifySelectForList($query);
        $query = $this->addAuthorization($query);
        $query = $this->addSearch($query, $search);
        $query = $this->addGroupBy($query);

        // TODO: Implement check of sortable fields
        if ($sort) {
            $query = $query->orderBy(
                $sort,
                $sort_direction,
            );
        }

        $count = $query->count();

        $items = $query
            ->skip($skip)
            ->limit($limit)
            ->get();

        $class_name = Str::plural(Str::snake((new \ReflectionClass($this))->getShortName()));

        return [
            $class_name => $items,
            'count' => $count,
            'limit' => $limit,
            'page' => $page,
            'pages' => ceil($count / $limit),
        ];
    }
}
