<?php

declare(strict_types=1);

namespace Domain\Order\Payment;

use Closure;
use Domain\Order\Contracts\PaymentGatewayContract;
use Domain\Order\Exceptions\PaymentProcessProcessException;
use Domain\Order\Exceptions\PaymentProviderProcessException;
use Domain\Order\Models\Payment;
use Domain\Order\Models\PaymentHistory;
use Domain\Order\States\Payment\PaidPaymentState;
use Domain\Order\Traits\PaymentEvents;

final class PaymentSystem
{
    use PaymentEvents;
    protected static PaymentGatewayContract $provider;

    /**
     * @throws PaymentProviderProcessException
     */
    public static function provider(PaymentGatewayContract|Closure $providerOrClosure):void
    {
        if(is_callable($providerOrClosure)) {
            $providerOrClosure = call_user_func($providerOrClosure);
        }

        if(!$providerOrClosure instanceof PaymentGatewayContract){
            throw PaymentProviderProcessException::providerRequired();
        }

        self::$provider = $providerOrClosure;
    }


    /**
     * @throws PaymentProviderProcessException
     */
    public static function create(PaymentData $paymentData): PaymentGatewayContract
    {
        if(!self::$provider instanceof PaymentGatewayContract){
            throw PaymentProviderProcessException::providerRequired();
        }

        Payment::query()->create([
            'payment_id' => $paymentData->id,
            'amount' => $paymentData->amount,
            'meta' => $paymentData->meta,
        ]);

        if(is_callable(self::$onCreating)) {
            $paymentData = call_user_func(self::$onCreating, $paymentData);
        }

        return self::$provider->data($paymentData);
    }

    /**
     * @throws PaymentProviderProcessException
     */
    public static function validate(): PaymentGatewayContract
    {
        if(!self::$provider instanceof PaymentGatewayContract){
            throw PaymentProviderProcessException::providerRequired();
        }

        PaymentHistory::query()->create([
            'method'          => request()->method(),
            'payload'         => self::$provider->request(),
            'payment_gateway' => get_class(self::$provider)
        ]);

        if(is_callable(self::$onValidating)) {
            call_user_func(self::$onValidating);
        }

        if(self::$provider->validate() && self::$provider->paid()){
            try {
                $payment = Payment::query()
                    ->where('payment_id', self::$provider->paymentId())
                    ->firstOr(function () {
                        throw PaymentProcessProcessException::paymentNotFound();
                    });

                if(is_callable(self::$onSuccess)) {
                    call_user_func(self::$onSuccess, $payment);
                }

                $payment->state->transitionTo(PaidPaymentState::class);

            } catch (PaymentProcessProcessException $e) {
                if(is_callable(self::$onError)) {
                    call_user_func(
                        self::$onError,
                        self::$provider->errorMessage() ?? $e->getMessage()
                    );
                }
            }
        }

        return self::$provider;
    }

}
