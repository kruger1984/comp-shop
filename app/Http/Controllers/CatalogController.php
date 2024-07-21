<?php

namespace App\Http\Controllers;

use App\View\ViewModels\CatalogViewModel;
use Domain\Catalog\Models\Category;


class CatalogController extends Controller
{
    public function __invoke(?Category $category): CatalogViewModel
    {
        //TODO make Cache (viewModel)
//        $brands = Brand::query()
//                       ->select(['id', 'title'])
//                       ->has('products')
//                       ->get();


        return (new CatalogViewModel($category))
            ->view('catalog.index');
    }
}
