<?php

declare(strict_types=1);

namespace Domain\Order\Exceptions;

use Exception;

final class PaymentProcessProcessException extends Exception
{
    public static function paymentNotFound(): self
    {
        return new self('Payment not found');
    }
}
