<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\Midtrans\CreatePaymentUrlService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function order(Request $request)
    {
        $order = Order::create([
            'user_id' => $request->user()->id,
            'number' => time() . uniqid(true),
            'payment_status' => 1,
            'delivery_address' => $request->delivery_address,
        ]);

        $total_price = 0;

        foreach ($request->items as $item) {
            $total_price += Product::find($item['id'])['price'] * $item['quantity'];

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
            ]);
        }

        // Call payment service
        $midtrans = new CreatePaymentUrlService($order->load('user'));

        $order->update([
            'payment_url' => $midtrans->getPaymentUrl(),
            'total_price' => $total_price,
        ]);

        $order->load('orderItems');
        return response()->json([
            'status' => 'order successfully',
            'data' => OrderResource::make($order),
        ]);
    }
}
