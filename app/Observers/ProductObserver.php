<?php

namespace App\Observers;

use Domain\Product\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductObserver
{

    /**
     * Handle the Product "created" event.
     *
     * @param  Product  $product
     * @return void
     */
    public function created(Product $product): void
    {
        $this->clearCache();
    }

    /**
     * Handle the Product "updated" event.
     *
     * @param  Product  $product
     * @return void
     */
    public function updated(Product $product): void
    {
        $this->clearCache();
    }

    /**
     * Handle the Product "deleted" event.
     *
     * @param  Product  $product
     * @return void
     */
    public function deleted(Product $product): void
    {
        $this->clearCache();
    }

    /**
     * Handle the Product "restored" event.
     *
     * @param  Product  $product
     * @return void
     */
    public function restored(Product $product): void
    {
        $this->clearCache();
    }

    /**
     * Handle the Product "forceDeleted" event.
     *
     * @param  Product  $product
     * @return void
     */
    public function forceDeleted(Product $product): void
    {
        $this->clearCache();
    }

    /**
     * Clear the cache associated with the Product model.
     *
     * @return void
     */
    protected function clearCache(): void
    {
        Cache::forget('product_home_page');
    }
}
