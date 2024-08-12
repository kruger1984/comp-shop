<?php

declare(strict_types=1);

namespace Domain\Order\Payment\GateWays;

use Domain\Order\Contracts\PaymentGatewayContract;
use Domain\Order\Payment\PaymentData;
use Illuminate\Http\JsonResponse;

final class UnitPay implements PaymentGatewayContract
{

    #[\Override] public function paymentId(): string
    {
        // TODO: Implement paymentId() method.
    }

    #[\Override] public function configure(array $config): void
    {
        // TODO: Implement configure() method.
    }

    #[\Override] public function data(PaymentData $data): PaymentGatewayContract
    {
        // TODO: Implement data() method.
    }

    #[\Override] public function request(): mixed
    {
        // TODO: Implement request() method.
    }

    #[\Override] public function response(): JsonResponse
    {
        // TODO: Implement response() method.
    }

    #[\Override] public function url(): string
    {
        // TODO: Implement url() method.
    }

    #[\Override] public function validate(): bool
    {
        // TODO: Implement validate() method.
    }

    #[\Override] public function paid(): bool
    {
        // TODO: Implement paid() method.
    }

    #[\Override] public function errorMessage(): string
    {
        // TODO: Implement errorMessage() method.
    }
}
