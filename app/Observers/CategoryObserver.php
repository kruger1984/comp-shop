<?php

namespace App\Observers;

use Domain\Catalog\Models\Category;
use Illuminate\Support\Facades\Cache;

class CategoryObserver
{
    /**
     * Handle the Category "created" event.
     *
     * @param  Category  $category
     * @return void
     */
    public function created(Category $category): void
    {
        $this->clearCache();
    }

    /**
     * Handle the Category "updated" event.
     *
     * @param  Category  $category
     * @return void
     */
    public function updated(Category $category): void
    {
        $this->clearCache();
    }

    /**
     * Handle the Category "deleted" event.
     *
     * @param  Category  $category
     * @return void
     */
    public function deleted(Category $category): void
    {
        $this->clearCache();
    }

    /**
     * Handle the Category "restored" event.
     *
     * @param  Category  $category
     * @return void
     */
    public function restored(Category $category): void
    {
        $this->clearCache();
    }

    /**
     * Handle the Category "forceDeleted" event.
     *
     * @param  Category  $category
     * @return void
     */
    public function forceDeleted(Category $category): void
    {
        $this->clearCache();
    }

    /**
     * Clear the cache associated with the Category model.
     *
     * @return void
     */
    protected function clearCache(): void
    {
        Cache::forget('category_home_page');
    }
}
