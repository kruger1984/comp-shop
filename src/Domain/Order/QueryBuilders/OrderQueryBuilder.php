<?php

declare(strict_types=1);

namespace Domain\Order\QueryBuilders;

use Domain\Catalog\Facades\Sorter;
use Domain\Catalog\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pipeline\Pipeline;

final class OrderQueryBuilder extends Builder
{

}
