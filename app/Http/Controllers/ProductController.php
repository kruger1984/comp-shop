<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class ProductController extends Controller
{
    public function __invoke(Product $product): Factory|View|Application
    {
        $product->load(['optionValues.option']);

        $also = [];
        if(session()->has('also')){
            $also = Product::query()->where(function ($q) use ($product) {
                $q->whereIn('id', session('also'))
                  ->where('id', '!=', $product->id);
            })->get();
        }



        $options = $product->optionValues->mapToGroups(function ($item) {
            return [$item->option->title => $item];
        });

        session()->put('also.' . $product->id, $product->id);

        return view('product.show', [
            'product' => $product,
            'options' => $options,
            'also'    => $also
        ]);
    }
}


//public function __invoke(Product $product): Factory|View|Application  // чат ЖПТ
//{
//    // Загрузка зависимостей
//    $product->load(['optionValues.option']);
//
//    // Сохраняем текущий продукт в сессии
//    session()->put('also' . $product->id, $product->id);
//
//    // Получаем все значения из сессии, начинающиеся с 'also'
//    $viewedProductIds = collect(session()->all())
//        ->filter(function ($value, $key) use ($product) {
//            return str_starts_with($key, 'also') && $value != $product->id;
//        })
//        ->values()
//        ->all();
//
//    // Загружаем просмотренные продукты, исключая текущий продукт
//    $alsoViewedProducts = Product::query()
//                                 ->whereIn('id', $viewedProductIds)
//                                 ->get();
//
//    // Группировка опций продукта
//    $options = $product->optionValues->mapToGroups(function ($item) {
//        return [$item->option->title => $item];
//    });
