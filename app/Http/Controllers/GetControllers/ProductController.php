<?php

namespace App\Http\Controllers\GetControllers;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Image;
use App\Models\Inclusion;
use App\Models\Product;
use App\Models\Product_attribute;
use App\Models\Review;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class ProductController extends Controller
{
    public function product(Product $product)
    {
        $product->images = Image::where("product", $product->id)->get();
        $product->inclusions = Inclusion::where("product", $product->id)->get();
        $product->attributes = Product_attribute::where("product", $product->id)
            ->join("attributes", "product_attributes.attribute", "=", "attributes.id")
            ->select("attributes.name", "product_attributes.value")
            ->get();
        // dd($product);
        $product->brand = Brand::find($product->brand);
        $categoryList = new Collection();
        $category = Category::find($product->category);

        $watchedList = new Collection();
        if (Cookie::get('watched')) {
            $watched = collect(json_decode(Cookie::get('watched')));
            foreach ($watched as $watch) {
                $watchedList->push(Product::find($watch));
            }
            $watchedList->transform(function ($item) {
                $item->image = Image::where("product", $item->id)->first();
                return $item;
            });
            $watched->prepend($product->id);
            if ($watched->count() > 20) $watched = $watched->slice(0, 20 - $watched->count());
        } else {
            $watched = collect([$product->id]);
        }

        $brandList = Product::where("brand", $product->brand)->limit(15)->get();
        $brandList->transform(function ($item) {
            $item->image = Image::where("product", $item->id)->first();
            return $item;
        });

        while (true) {
            $categoryList->push($category);
            if (!$category->parent_id) break;
            $category = Category::find($category->parent_id);
        }
        $categoryList = $categoryList->sortBy("depth");

        $reviews = Review::where("product", $product->id)
            ->join("users", "reviews.user", "=", "users.id")
            ->select("reviews.*", "users.name as name")
            ->get();

        $product->category = Category::find($product->category);
        return response(view('product', [
            'product' => $product,
            'reviews' => $reviews,
            'categoryList' => $categoryList,
            'watchedList' => $watchedList,
            'brandList' => $brandList,
        ]))->withCookie(cookie()->forever('watched', $watched->toJson()));
    }
}
