<?php

declare(strict_types=1);

namespace Domain\Catalog\ViewModels;

use Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Support\Trait\Makeable;

final class ProductViewModel
{
    use Makeable;
    public function homePage(): Collection|array
    {
        return Cache::rememberForever('product_home_page', function (){
            return Product::query()
                           ->homepage()
                           ->get();
        });
    }

}
