<?php

namespace App\Observers;

use Domain\Catalog\Models\Brand;
use Illuminate\Support\Facades\Cache;

class BrandObserver
{
    /**
     * Handle the Brand "created" event.
     *
     * @param  Brand  $brand
     * @return void
     */
    public function created(Brand $brand): void
    {
        $this->clearCache();
    }

    /**
     * Handle the Brand "updated" event.
     *
     * @param  Brand  $brand
     * @return void
     */
    public function updated(Brand $brand): void
    {
        $this->clearCache();
    }

    /**
     * Handle the Brand "deleted" event.
     *
     * @param  Brand  $brand
     * @return void
     */
    public function deleted(Brand $brand): void
    {
        $this->clearCache();
    }

    /**
     * Handle the Brand "restored" event.
     *
     * @param  Brand  $brand
     * @return void
     */
    public function restored(Brand $brand): void
    {
        $this->clearCache();
    }

    /**
     * Handle the Brand "forceDeleted" event.
     *
     * @param  Brand  $brand
     * @return void
     */
    public function forceDeleted(Brand $brand): void
    {
        $this->clearCache();
    }

    /**
     * Clear the cache associated with the Brand model.
     *
     * @return void
     */
    protected function clearCache(): void
    {
        Cache::forget('brand_home_page');
    }
}
