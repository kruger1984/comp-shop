<?php

declare(strict_types=1);

namespace Domain\Order\Processes;

use Domain\Order\Contracts\OrderProcessContract;
use Domain\Order\Models\Order;
use Illuminate\Support\Facades\DB;

final class DecreaseProductsQuantities implements OrderProcessContract
{
    public function handle(Order $order, $next) // TODO При отмене транзакции вернуть назад кол-во
    {
        foreach (cart()->items() as $item) {
            $item->product()->update([
                'quantity' => DB::raw('quantity - ' . $item->quantity)
            ]);
        }

        return $next($order);
    }
}
