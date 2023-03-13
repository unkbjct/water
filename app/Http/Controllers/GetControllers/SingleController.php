<?php

namespace App\Http\Controllers\GetControllers;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Image;
use App\Models\Order;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class SingleController extends Controller
{
    public function order()
    {
        $cart = collect(json_decode(Cookie::get('cart')));

        if ($cart->isEmpty()) return redirect()->route('home');

        $cartList = new Collection();
        foreach ($cart as $cartItem) {
            $productFromBd = Product::find($cartItem->id);
            $productFromBd->image = Image::where("product", $productFromBd->id)->first()->url;
            $productFromBd->brand = Brand::find($productFromBd->brand)->name;
            $productFromBd->category = Category::find($productFromBd->category)->title;
            $productFromBd->count = $cartItem->count;
            $cartList->push($productFromBd);
        }

        $fullPrice = 0;
        $fullCount = 0;
        $fullSale  = 0;
        foreach ($cartList as $cartItem) {
            $fullCount += $cartItem->count;
            if ($cartItem->sale)
                $fullSale += ($cartItem->price * ($cartItem->sale / 100)) * $cartItem->count;
            $fullPrice += $cartItem->price * $cartItem->count;
        }
        return view('order', [
            'cart' => $cartList,
            'fullPrice' => $fullPrice,
            'fullCount' => $fullCount,
            'fullSale' => $fullSale,
        ]);
    }

    public function orderSuccessful(Transaction $transaction, Request $request)
    {
        $order = Order::where("transaction", $transaction->id)->get();
        // dd($order->isNotEmpty());
        if ($order->isEmpty()) {
            sleep(1);
            $this->orderSuccessful($transaction);
            return;
        }
        $order = $order[0];
        // dd($order);
        return view('order-successful', [
            'order' => $order,
            'mobile' => $request->input("mobile"),
        ]);
    }

    public function information()
    {
        return view('information');
    }

    public function brands()
    {
        $brands = Brand::all();
        return view('brands', [
            'brands' => $brands
        ]);
    }
}
