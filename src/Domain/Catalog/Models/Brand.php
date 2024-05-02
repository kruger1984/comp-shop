<?php

namespace Domain\Catalog\Models;

use App\Models\Product;
use Database\Factories\BrandFactory;
use Domain\Catalog\QueryBuilders\BrandQueryBuilder;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Support\Trait\Models\HasSlug;
use Support\Trait\Models\HasThumbnail;


/**
 * @method static Brand|BrandQueryBuilder query()
 *
 */
class Brand extends Model
{
    use HasFactory;
    use HasSlug;
    use HasThumbnail;

    protected $fillable = [
        'title',
        'slug',
        'thumbnail',
        'on_home_page',
        'sorting'
    ];
    protected function thumbnailDir(): string
    {
        return 'brands';
    }

public function newEloquentBuilder($query): BrandQueryBuilder
{
    return new BrandQueryBuilder($query);
}

    public function products() : HasMany
    {
      return $this->hasMany(Product::class);
    }
}
