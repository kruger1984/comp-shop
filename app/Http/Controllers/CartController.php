<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartRequest;
use Domain\Cart\Models\CartItem;
use Domain\Product\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(): Factory|View|Application
    {
        return view('cart.index', [
            'items' => cart()->items()
        ]);
    }

    public function add(Product $product): RedirectResponse
    {
        cart()->add(
            $product,
            request('quantity',1),
            request('options',[])
        );


        flash()->info('Товар добавлен в корзину');

        return redirect()
            ->intended(route('cart'));
    }

    public function quantity(CartItem $item, CartRequest $request): RedirectResponse
    {

        if($request->input('quantity') == 1 && $request->input('action') == '-'){
            flash()->alert('Минимальное кол-во товара 1');
            return redirect()->back();
        }

        if(($request->input('action') == '+') ) {
            cart()->quantity($item, $request->input('quantity') + 1);
        }
        else {
            cart()->quantity($item, $request->input('quantity') - 1);
        }

        flash()->info('Кол-во товаров изменено');

        return redirect()
            ->intended(route('cart'));

    }

    public function delete(CartItem $item): RedirectResponse
    {
        cart()->delete($item);

        flash()->info('Удалено из корзины');

        return redirect()
            ->intended(route('cart'));
    }
    public function truncate(): RedirectResponse
    {
        cart()->truncate();

        flash()->info('Корзина очищена');

        return redirect()
            ->intended(route('cart'));
    }



}
