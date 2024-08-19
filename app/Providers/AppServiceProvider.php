<?php

namespace App\Providers;

use App\Observers\BrandObserver;
use App\Observers\CategoryObserver;
use App\Observers\ProductObserver;
use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Domain\Product\Models\Product;
use Illuminate\Foundation\Http\Kernel;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Connection;
use Services\TelegramBotApi;
use Services\TelegramBotApiContract;

//use Illuminate\Database\Events\QueryExecuted;

class AppServiceProvider extends ServiceProvider
{

    public function boot() : void
    {
        Model::shouldBeStrict(!app()->isProduction());

        $this->app->bind(TelegramBotApiContract::class, TelegramBotApi::class);

        if(app()->isProduction())
        {

            DB::listen(function ($query){

                if($query->time > 100)
                {
                    logger()
                        ->channel('telegram')
                        ->debug('query longer than 1ms' . $query->sql, $query->bindings);
                }
            });

            app(Kernel::class)->whenRequestLifecycleIsLongerThan(
                CarbonInterval::seconds(4),
                function (){
                    logger()
                        ->channel('telegram')
                        ->debug('whenRequestLifecycleIsLongerThan:' . request()->url());
                }
            );
        }

        /***************
         * Observers
         **************/

        Brand::observe(BrandObserver::class);
        Category::observe(CategoryObserver::class);
        Product::observe(ProductObserver::class);


    }
}
