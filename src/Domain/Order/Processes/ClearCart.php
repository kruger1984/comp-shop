<?php

declare(strict_types=1);

namespace Domain\Order\Processes;

use Domain\Order\Contracts\OrderProcessContract;
use Domain\Order\Models\Order;
use Domain\Order\Models\OrderItem;

final class ClearCart implements OrderProcessContract
{

    public function handle(Order $order, $next)
    {

        cart()->truncate();

        return $next($order);
    }
}
