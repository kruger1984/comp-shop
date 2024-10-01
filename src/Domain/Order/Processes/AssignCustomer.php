<?php

declare(strict_types=1);

namespace Domain\Order\Processes;

use Domain\Order\Contracts\OrderProcessContract;
use Domain\Order\DTOs\OrderCustomerDTO;
use Domain\Order\Models\Order;
use Illuminate\Support\Facades\Auth;

final class AssignCustomer implements OrderProcessContract
{
    public function __construct(protected OrderCustomerDTO $customer)
    {
    }

    public function handle(Order $order, $next)
    {
        $order->orderCustomer()
            ->create($this->customer->toArray());

        if(Auth::user()){
            $order->update([
                'user_id' => Auth::id()
            ]);
        }

        return $next($order);
    }
}
