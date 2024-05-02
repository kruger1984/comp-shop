<?php

declare(strict_types=1);

namespace Tests\Feature\app\Http\Controllers;

use App\Http\Controllers\HomeController;
use App\Models\Product;
use Database\Factories\BrandFactory;
use Database\Factories\CategoryFactory;
use Database\Factories\ProductFactory;
use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Domain\Catalog\ViewModels\CategoryViewModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @return void
     * */
    public function it_success_response(): void
    {
        ProductFactory::new()->count(5)
                      ->create([
                          'on_home_page' => true,
                          'sorting'      => 999
                      ]);

        $product = ProductFactory::new()
                                 ->createOne([
                                     'on_home_page' => true,
                                     'sorting'      => 1
                                 ]);
        CategoryFactory::new()->count(5)
                      ->create([
                          'on_home_page' => true,
                          'sorting'      => 999
                      ]);

        $category = CategoryFactory::new()
                                 ->createOne([
                                     'on_home_page' => true,
                                     'sorting'      => 1
                                 ]);
        BrandFactory::new()->count(5)
                      ->create([
                          'on_home_page' => true,
                          'sorting'      => 999
                      ]);

        $brand = BrandFactory::new()
                                 ->createOne([
                                     'on_home_page' => true,
                                     'sorting'      => 1
                                 ]);
        $this->get(action(HomeController::class))
             ->assertOk()
             ->assertViewHas('categories.0', $category)
             ->assertViewHas('products.0', $product)
             ->assertViewHas('brands.0', $brand);
    }

}
