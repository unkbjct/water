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
use Illuminate\Database\Eloquent\Collection;

class PaymentController extends Controller
{
    public function index()
    {
    }


    public function create(Request $request, PaymentService $service)
    {
        $descripption = "Покупка товара";

        $cart = ($request->input("mobile") == true) ? collect(json_decode($request->input("cart"))) : collect(json_decode(Cookie::get('cart')));
        if($request->input("mobile")) {
            $tmpCart = new collection();
            foreach($cart as $cartItem) {
                $tmpProduct = Product::find($cartItem->id);
                $tmpProduct->count = $cartItem->count;
                $tmpCart->push($tmpProduct);
            }
            $cart = $tmpCart;
            $sendCart = $tmpCart;
        }else{
            $sendCart = [];
            foreach($cart as $cartItem) {
                array_push($sendCart, [
                    'id' => $cartItem->id,
                    'count' => $cartItem->count
                ]);
            }
        }

        $fullPrice = 0;
        $fullSale  = 0;
        foreach ($cart as $cartItem) {
            $fullSale += ($cartItem->price * ($cartItem->sale / 100)) * $cartItem->count;
            $fullPrice += $cartItem->price * $cartItem->count;
        }

        $price = (float)$fullPrice - $fullSale;

        // return ($request->input());

        $transaction = new Transaction();
        $transaction->price = $price;
        $transaction->user = ($request->input("mobile") == true) ? $request->input("user") : Auth::user()->id;
        $transaction->description = $descripption;
        $transaction->save();

        $link = $service->createPayment($price, $descripption, [
            'user' => ($request->input("mobile") == true) ? $request->input("user") : Auth::user()->id,
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
            'cart' => ($request->input("mobile") == true) ? $request->input("cart") : json_encode($sendCart),
            'mobile' => $request->input("mobile"),
        ]);

        return ($request->input("mobile") == true) ? $link : redirect($link);
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

                // return;

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

                // $idList = [];
                // foreach ($cart as $cartItem) {
                //     array_push($idList, $cartItem->id);
                // }
                // $cart
                foreach ($cart as $cartItem) {

                    $product = Product::find($cartItem->id);
                    $orderProduct = new Order_product();
                    $orderProduct->order_id = $order->id;
                    $orderProduct->product = $product->id;
                    $orderProduct->count = $cartItem->count;
                    $orderProduct->price = $product->price;
                    $orderProduct->sale = $product->sale;
                    $orderProduct->save();
                Log::debug("success");
                }
            }
        }
    }
    //
}
