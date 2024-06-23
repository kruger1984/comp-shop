<?php

declare(strict_types=1);

namespace Domain\Product\QueryBuilders;

use Domain\Catalog\Facades\Sorter;
use Domain\Catalog\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pipeline\Pipeline;

final class ProductQueryBuilder extends Builder
{
    public function homepage(): ProductQueryBuilder
    {
        return $this->where('on_home_page', true)
                    ->orderBy('sorting')
                    ->limit(6);
    }

    public function filtered(): ProductQueryBuilder
    {
        return app(Pipeline::class)
            ->send($this)
            ->through(filters())
            ->thenReturn();
    }

    public function search(): ProductQueryBuilder
    {
        return $this->when(request('s'), function (\Illuminate\Contracts\Database\Query\Builder $query) {
            $query->whereFullText(['title', 'text'], request('s'));
        });
    }

    public function withCategory(Category $category): ProductQueryBuilder
    {
        return $this->when(
            $category->exists,
            function (\Illuminate\Contracts\Database\Query\Builder $query) use ($category) {
                $query->whereRelation(
                    'categories',
                    'categories.id',
                    '=',
                    $category->id
                );
            }
        );
    }

    public function sorted(): Builder|ProductQueryBuilder
    {
        return Sorter::run($this);
    }
}
