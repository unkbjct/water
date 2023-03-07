<?php

namespace App\Http\Controllers\GetControllers;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Image;
use App\Models\Order;
use App\Models\Order_product;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    // ---LOGIN
    public function login()
    {
        return view('account.login');
    }

    // ---SIGNUP
    public function signUp()
    {
        return view('account.signUp');
    }

    // ---LOGOUT
    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }
    // ---PROFILE
    public function personal()
    {
        return view('account.personal');
    }

    // ---FAVORITES
    public function favorites()
    {
        if (!isset($_COOKIE['favorites'])) return view('account.favorites');
        $produts = Product::whereIn("id", explode(",", $_COOKIE['favorites']))->get();
        $produts->transform(function ($prod) {
            $prod->images = Image::where("product", $prod->id)->get();
            return $prod;
        });

        return view('account.favorites', [
            'products' => $produts,
        ]);
    }

    // ---HISTORY
    public function history()
    {
        $orders = Order::where("user", Auth::user()->id)->orderByDesc('id')->get();
        $orders->transform(function ($order) {
            $products = Order_product::where("order_id", $order->id)->get();

            $products->transform(function ($product) {
                $productFromBd = Product::find($product->product);
                $productFromBd->sale = $product->sale;
                $productFromBd->price = $product->price;
                $productFromBd->count = $product->count;

                $productFromBd->category = Category::find($productFromBd->category);
                $productFromBd->brand = Brand::find($productFromBd->brand)->name;
                $productFromBd->image = Image::where("product", $productFromBd->id)->first()->url;

                return $productFromBd;
            });

            $fullPrice = 0;
            $fullCount = 0;
            $fullSale  = 0;
            foreach ($products as $product) {
                $fullCount += $product->count;
                if ($product->sale)
                    $fullSale += ($product->price * ($product->sale / 100)) * $product->count;
                $fullPrice += $product->price * $product->count;
            }

            $order->fullPrice = $fullPrice - $fullSale;
            $order->fullCount = $fullCount;
            $order->products = $products;
            return $order;
        });
        return view('account.history', [
            'orders' => $orders,
        ]);
    }

    // ---WATCHED
    public function watched()
    {
        return view('account.watched');
    }
}
