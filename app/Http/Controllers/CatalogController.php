<?php

namespace App\Http\Controllers;

use App\View\ViewModels\CatalogViewModel;
use Domain\Catalog\Models\Category;
use Domain\Product\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;


class CatalogController extends Controller
{
    public function __invoke(?Category $category): CatalogViewModel
    {
        //TODO make Cache (viewModel)
//        $brands = Brand::query()
//                       ->select(['id', 'title'])
//                       ->has('products')
//                       ->get();


//        return view('catalog.index', new CatalogViewModel($category));
        return (new CatalogViewModel($category))
            ->view('catalog.index');
    }
}
