<?php

declare(strict_types=1);

namespace Domain\Order\Processes;

use Domain\Order\Contracts\OrderProcessContract;
use Domain\Order\Exceptions\OrderProcessException;
use Domain\Order\Models\Order;
use Illuminate\Support\Facades\DB;
use Throwable;

final class DecreaseProductsQuantities implements OrderProcessContract
{
    protected array $updatedProducts = [];

    public function handle(Order $order, $next)
    {
//        try {
            foreach (cart()->items() as $item) {
                $product = $item->product();

                $product->update([
                    'quantity' => DB::raw('quantity - ' . $item->quantity)
                ]);

//                $this->updatedProducts[] = [
//                    'product_id' => $product->id,
//                    'quantity'   => $item->quantity,
//                ];
            }

            return $next($order);
//        } catch (Throwable $e) {
//            $this->rollbackQuantities();
//            throw new OrderProcessException('Ошибка уменьшения коли-ва товара.');
//        }

    }

    protected function rollbackQuantities(): void
    {
        foreach ($this->updatedProducts as $productData) {
            DB::table('products')->where('id', $productData['product_id'])->update([
                'quantity' => DB::raw('quantity + ' . $productData['quantity']),
            ]);
        }
    }
}
