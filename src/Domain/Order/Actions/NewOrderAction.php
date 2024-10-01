<?php

declare(strict_types=1);

namespace Domain\Order\Actions;

use App\Http\Requests\OrderFormRequest;
use Domain\Auth\Contracts\RegisterNewUserContract;
use Domain\Auth\DTOs\NewUserDTO;
use Domain\Order\DTOs\OrderCustomerDTO;
use Domain\Order\DTOs\OrderDTO;
use Domain\Order\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

final class NewOrderAction
{

    public function __invoke(OrderDTO $order, OrderCustomerDTO $customer, bool $createAccount): Order
    {
        $registerAction = app(RegisterNewUserContract::class);

        $order = Order::query()->create([
            'payment_method_id' => $order->payment_method_id,
            'delivery_type_id'  => $order->delivery_type_id,
            'amount'            => cart()->amount()
        ]);


        if ($createAccount) {
            $registerAction(
                NewUserDTO::make(
                    $customer->fullName(),
                    $customer->email,
                    $order->password,
                )
            );
            $order->update([
                 'user_id' => auth()->id(),
            ]);
        }

        return $order;
    }
}
