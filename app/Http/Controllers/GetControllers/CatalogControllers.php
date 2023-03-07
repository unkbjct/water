<?php

namespace App\Http\Controllers\GetControllers;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\Product_attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class CatalogControllers extends Controller
{
    public function catalog(Request $request, $category)
    {
        $request->flash();

        $category = Category::where("title_eng", $category)->first();
        $thisCategory = $category;
        $listCategories = new Collection();
        $listCategories = $this->buildChildList($listCategories, $category);
        $idListCategories = [];
        array_push($idListCategories, $category->id);
        foreach ($listCategories as $item) {
            array_push($idListCategories, $item->id);
        }

        $products = Product::whereIn("category", $idListCategories);

        if ($request->has("isHave")) $products->where("count", ">", 0);
        if ($request->has("isSale")) $products->where("sale", ">", 0);
        if ($request->has("price-from") && $request->input("price-from")) $products->where("price", ">=", $request->input("price-from"));
        if ($request->has("price-to") && $request->input("price-to")) $products->where("price", "<=", $request->input("price-to"));
        if ($request->has('brands')) $products->whereIn("brand", $request->input('brands'));
        if ($request->has('sort') && $request->input('sort')) $products->orderBy(explode(":", $request->input('sort'))[0], explode(":", $request->input('sort'))[1]);
        if ($request->has('title') && $request->input('title')) $products->where("title", "like", "%{$request->input('title')}%");

        $products = $products->get();


        // dd($attributes);


        $products->transform(function ($prod) {
            $prod->images = Image::where("product", $prod->id)->get();
            return $prod;
        });

        $categoryList = new Collection();

        while (true) {
            $categoryList->push($category);
            if (!$category->parent_id) break;
            $category = Category::find($category->parent_id);
        }
        $categoryList = $categoryList->sortBy("depth");

        // foreach ($categoryList as $item) {
        //     array_push($idListCategories, $item->id);
        // }

        // dd($request->input('attributes'));
        // if ($request->has('attributes')) {

        // }

        // $attributes = Attribute::whereIn("category", $idListCategories)->get();
        // $attributes->transform(function ($attr) {
        //     $values = Product_attribute::where("attribute", $attr->id)->get();
        //     if ($values->isEmpty()) return;
        //     $attr->values = $values;
        //     return $attr;
        // });
        // $attributes = $attributes->reject(function ($item) {
        //     return $item == null;
        // });


        $treeCategories = Category::all();
        $treeCategories->transform(function ($category) {
            $category = $this->buildChildTree($category);
            return $category;
        });
        $treeCategories = $treeCategories->reject(function ($item) {
            return $item->parent_id !== null;
        });

        $brands = Brand::all();

        return view('search', [
            'thisCategory' => $thisCategory,
            'products' => $products,
            'categoryList' => $categoryList,
            'categoryTree' => $treeCategories,
            'brands' => $brands,
            // 'attributes' => $attributes,
        ]);
    }

    function buildChildList($list, $item)
    {
        $children = Category::where("parent_id", $item->id)->get();
        foreach ($children as $child) {
            $list->push($child);
            $this->buildChildList($list, $child);
        }
        return $list;
    }

    function buildChildTree($item)
    {
        $children = Category::where("parent_id", $item->id)->get();

        $children->transform(function ($child) {
            $this->buildChildTree($child);
            return $child;
        });

        $item->children = $children;
        return $item;
    }
}
