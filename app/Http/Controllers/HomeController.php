<?php

namespace App\Http\Controllers;

use Domain\Catalog\ViewModels\BrandViewModel;
use Domain\Catalog\ViewModels\CategoryViewModel;
use Domain\Catalog\ViewModels\ProductViewModel;
use Domain\Product\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __invoke(): Factory|View|Application
    {
        $categories = CategoryViewModel::make()->homePage();

        $products = ProductViewModel::make()->homePage();

        $brands = BrandViewModel::make()->homePage();

        return view('index', compact('categories','products','brands'
        ));
    }
}
