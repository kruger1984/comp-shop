<?php

namespace Domain\Order\Providers;

use Domain\Order\Exceptions\PaymentProviderProcessException;
use Domain\Order\Models\Payment;
use Domain\Order\Payment\GateWays\UnitPay;
use Domain\Order\Payment\GateWays\YooKassa;
use Domain\Order\Payment\PaymentData;
use Domain\Order\Payment\PaymentSystem;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    public function register(): void
    {


    }

    /**
     * @throws PaymentProviderProcessException
     */
    public function boot(): void
    {

        PaymentSystem::provider(function () {
            return new YooKassa();
        });

//        PaymentSystem::provider(function (){
//            if(request()->has('unitpay')) {
//                return UnitPay();
//            }
//
//            return YooKassa();
//        });

        PaymentSystem::onCreating(function (PaymentData $paymentData){

            return $paymentData;
        });

        PaymentSystem::onSuccess(function (Payment $payment){

        });

        PaymentSystem::onError(function (string $message, Payment $payment){

        });

    }


}
