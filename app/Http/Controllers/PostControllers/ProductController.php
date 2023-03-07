<?php

namespace App\Http\Controllers\PostControllers;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class ProductController extends Controller
{

    public function cartAdd(Product $product, Request $request)
    {
        $product->image = Image::where("product", $product->id)->first()->url;
        $product->brand = Brand::find($product->brand)->name;
        $product->category = Category::find($product->category)->title;
        $cart = $request->cookie('cart');

        
        if ($cart) {
            $cart = collect(json_decode($cart));
            $isFounded = false;
            foreach ($cart as $cartItem) {
                if ($cartItem->id == $product->id) {
                    $cartItem->count++;
                    $isFounded = !$isFounded;
                }
            }
            if (!$isFounded) {
                $product->count = 1;
                $cart->push($product);
            }
        } else {
            $cart = new Collection();
            $product->count = 1;
            $cart->push($product);
        }
        return redirect()->back()->withCookie(cookie()->forever('cart', $cart->toJson()))->withErrors(['showCart' => true]);
    }

    public function cartRemove(Product $product, Request $request)
    {
        $cart = $request->cookie('cart');
        if (!$cart) redirect()->route('home');
        $cart = collect(json_decode($cart));
        // $cart->transform(function ($cartItem)
        // {
        //     if($)
        //     return $cartItem;
        // });
        foreach ($cart as $cartItem) {
            if ($cartItem->id == $product->id) {
                ($cartItem->count == 1) ?
                    $cart = $cart->whereNotIn('id', $cartItem->id) :
                    $cartItem->count--;
            }
        }
        // dd($cart);
        if ($cart->isEmpty()) {
            Cookie::queue(Cookie::forget('cart'));
            return redirect()->back();
        };
        return redirect()->back()->withCookie(cookie()->forever('cart', $cart->toJson()))->withErrors(['showCart' => true]);
    }

    public function reviewCreate(Request $request, Product $product)
    {
        $review = new Review();
        $review->user = Auth::user()->id;
        $review->product = $product->id;
        $review->rating = $request->input('raiting');
        $review->advantages = $request->input('advantages');
        $review->flaw = $request->input('flaw');
        $review->comment = $request->input('comment');
        $review->save();

        $sum = $product->raiting_sum + $request->input('raiting');
        $count = $product->raiting_count + 1;

        $product->rating_count = $count;
        $product->rating_sum = $sum;
        $product->rating = (float)($sum / $count);
        $product->save();

        return redirect()->back()->with(['success' => 'Отзыв оставлен успешно!']);
    }
}
