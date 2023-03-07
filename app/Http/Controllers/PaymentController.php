<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Order_product;
use App\Models\Product;
use App\Models\Transaction;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use YooKassa\Model\Notification\NotificationSucceeded;
use YooKassa\Model\Notification\NotificationWaitingForCapture;
use YooKassa\Model\NotificationEventType;

class PaymentController extends Controller
{
    public function index()
    {
    }


    public function create(Request $request, PaymentService $service)
    {
        $descripption = "Покупка товара";

        $cart = collect(json_decode(Cookie::get('cart')));
        $cart->transform(function ($cartItem) {
            $product = Product::find($cartItem->id);
            $product->count = $cartItem->count;
            return $product;
        });

        $fullPrice = 0;
        $fullSale  = 0;
        foreach ($cart as $cartItem) {
            $fullSale += ($cartItem->price * ($cartItem->sale / 100)) * $cartItem->count;
            $fullPrice += $cartItem->price * $cartItem->count;
        }

        $price = (float)$fullPrice - $fullSale;

        $transaction = new Transaction();
        $transaction->price = $price;
        $transaction->user = Auth::user()->id;
        $transaction->description = $descripption;
        $transaction->save();

        $link = $service->createPayment($price, $descripption, [
            'user' => Auth::user()->id,
            'name' => $request->input('name'),
            'surname' => $request->input('surname'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'city' => $request->input('city'),
            'street' => $request->input('street'),
            'house' => $request->input('house'),
            'apart' => $request->input('apart'),
            'build' => $request->input('build'),
            'comment' => $request->input('comment'),
            'transaction' => $transaction->id,
            'cart' => Cookie::get('cart'),
        ]);

        return redirect($link);
    }


    public function callback(Request $request, PaymentService $service)
    {
        $source = file_get_contents('php://input');
        $requestBody = json_decode($source, true);

        $notification = (isset($requestBody['event']) && $requestBody['event'] === NotificationEventType::PAYMENT_SUCCEEDED)
            ? new NotificationSucceeded($requestBody)
            : new NotificationWaitingForCapture($requestBody);

        $payment = $notification->getObject();

        if (isset($payment->status) && $payment->status === 'waiting_for_capture') {
            $service->getClient()->capturePayment([
                'amount' => $payment->amount,
            ], $payment->id, uniqid('', true));
        }


        if (isset($payment->status) && $payment->status === 'succeeded') {
            if ((bool)$payment->paid === true) {

                $metadata = (object)$payment->metadata;
                $transaction = Transaction::find($metadata->transaction);
                $transaction->status = "FINISHED";
                $transaction->save();


                $order = new Order();
                $cart = collect(json_decode($metadata->cart));
                $order->status = "PROCESSING";
                $order->transaction = $transaction->id;
                $order->user = $metadata->user;
                $order->name = $metadata->name;
                $order->surname = $metadata->surname;
                $order->email = $metadata->email;
                $order->phone = $metadata->phone;

                $order->city = $metadata->city;
                $order->street = $metadata->street;
                $order->house = $metadata->house;
                $order->apart = $metadata->apart;
                $order->build = $metadata->build;
                $order->comment = $metadata->comment;
                $order->save();

                foreach ($cart as $cartItem) {

                    $product = Product::find($cartItem->id);
                    $orderProduct = new Order_product();
                    $orderProduct->order_id = $order->id;
                    $orderProduct->product = $product->id;
                    $orderProduct->count = $cartItem->count;
                    $orderProduct->price = $product->price;
                    $orderProduct->sale = $product->sale;
                    $orderProduct->save();
                    Log::debug(123);
                }
            }
        }
    }
    //
}
