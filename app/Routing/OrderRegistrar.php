<?php

declare(strict_types=1);

namespace App\Routing;

use App\Contracts\RouteRegistrar;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Facades\Route;

final class OrderRegistrar implements RouteRegistrar
{
    public function map(Registrar $registrar): void
    {
        Route::middleware(['web'])->group(function (){

            Route::controller(OrderController::class)
                 ->prefix('order')
                 ->group(function (){
                    Route::get('/', 'index')->name('order');
                    Route::post('/', 'handle')->name('order.handle');
                    Route::get('/list', 'list')->name('order.list');
                    Route::get('/success/{order}', 'success')->name('order.success');
                    Route::get('/{order}', 'show')->name('order.show');
                    Route::delete('/{order}', 'delete')->name('order.delete');

                });
        });
    }
}
