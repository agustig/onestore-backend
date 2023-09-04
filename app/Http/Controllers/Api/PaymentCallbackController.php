<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Library\ApiHelpers;
use App\Models\Order;
use App\Services\Midtrans\CallbackService;

class PaymentCallbackController extends Controller
{
    use ApiHelpers;

    public function callback()
    {
        $callback = new CallbackService;

        if ($callback->isSignatureKeyVerified()) {
            $notification = $callback->getNotification();
            $order = $callback->getOrder();

            if ($callback->isSuccess()) {
                Order::where('id', $order->id)->update([
                    'payment_status' => 2,
                    'payment_type' => $notification->payment_type,
                ]);
            }

            if ($callback->isExpire()) {
                Order::where('id', $order->id)->update(['payment_status' => 3]);
            }

            if ($callback->isCancelled()) {
                Order::where('id', $order->id)->update(['payment_status' => 4]);
            }

            if ($callback->isFailure()) {
                Order::where('id', $order->id)->update(['payment_status' => 5]);
            }
            return $this->onSuccess(null, 'Notification is processed');
        } else {
            return $this->onError(403, 'Unsigned signature key');
        }
    }
}
