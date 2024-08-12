<?php

declare(strict_types=1);

namespace Domain\Order\Actions;

use App\Http\Requests\OrderFormRequest;
use Domain\Auth\Contracts\RegisterNewUserContract;
use Domain\Auth\DTOs\NewUserDTO;
use Domain\Order\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

final class NewOrderAction
{
//    public function __invoke(OrderFormRequest $request)
    public function __invoke(OrderFormRequest $request): Order
    {
        $registerAction = app(RegisterNewUserContract::class);

        $customer = $request->get('customer');

        if ($request->boolean('create_account')) {
            $registerAction(
                NewUserDTO::make(
                    $customer['first_name'] . ' ' . $customer['last_name'],
                    $customer['email'],
                    $request->get('password'),
                )
            );
        }
// TODO Разобратся с ошибкой

        return Order::query()->create([
            // 'user_id' => auth()->id(),
            'payment_method_id' => $request->get('payment_method_id'),
            'delivery_type_id'  => $request->get('delivery_type_id'),
        ]);
    }
}
