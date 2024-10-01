<?php

declare(strict_types=1);

namespace Domain\Order\Processes;

use Domain\Order\Contracts\OrderProcessContract;
use Domain\Order\Models\Order;

final class AssignProducts implements OrderProcessContract
{

    public function handle(Order $order, $next)
    {
        $orderItems = $order->orderItems()
            ->createMany(
                cart()->items()->map(function ($item) {
                    return [
                        'product_id' => $item->product_id,
                        'price'      => $item->price,
                        'quantity'   => $item->quantity,
                    ];
                })->toArray()
            );
//        $order->update([
//            'amount' => cart()->amount()
//        ]);

        foreach ($orderItems as $orderItem) {

            $cartItem = cart()->items()->firstWhere('product_id', $orderItem->product_id);

            if ($cartItem && isset($cartItem->optionValues)) {

                $optionValueIds = $cartItem->optionValues->pluck('id')->toArray();

                $orderItem->optionValues()->sync($optionValueIds);
            }
        }

        return $next($order);
    }
}
