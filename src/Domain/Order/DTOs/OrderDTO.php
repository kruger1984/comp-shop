<?php

declare(strict_types=1);

namespace Domain\Order\DTOs;

use Illuminate\Http\Request;
use Support\Trait\Makeable;

final class OrderDTO
{
    use Makeable;

    public function __construct(
        public readonly array $customer,
        public readonly bool $createAccount,
        public readonly ?string $password,
        public readonly ?int $userId,
        public readonly int $paymentMethodId,
        public readonly int $deliveryTypeId,
        public readonly ?int $amount
    )
    {
    }

    public static function fromRequest(Request $request): self
    {
//        return self::make(
//            customer: $request->input('customer', []),
//            createAccount: $request->boolean('create_account'),
//            password: $request->input('password'),
//            userId: $request->input('user_id'),
//            paymentMethodId: $request->input('payment_method_id'),
//            deliveryTypeId: $request->input('delivery_type_id'),
//            amount: $request->input('amount')
//        );
        return OrderDTO::make(...$request->only(['customer', 'create_account', 'password', 'password_confirmation', 'user_id', 'payment_method_id', 'delivery_type_id', 'amount']));
    }
}
