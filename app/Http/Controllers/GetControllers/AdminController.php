<?php

namespace App\Http\Controllers\GetControllers;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Image;
use App\Models\Inclusion;
use App\Models\Product;
use App\Models\Order;
use App\Models\Order_product;
use App\Models\Product_attribute;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\Object_;

use function PHPSTORM_META\type;

class AdminController extends Controller
{
    public function products(Request $request)
    {
        $products = Product::join("categories", "products.category", "=", "categories.id")->select("products.*", "categories.title as category");
        $products = $this->filter($products, $request)->get();
        // dd($products);


        return view('admin.products', [
            'products' => $products,
        ]);
    }

    public function productsCreate()
    {
        $categories = Category::all();
        $categories->transform(function ($category) {

            $category->parent_title = ($category->parent_id) ? Category::find($category->parent_id)->title : 'нет';
            $category->parentAttributes = new Collection;
            $category = $this->findParentAttributes($category->id, $category);

            return $category;
        });

        $brands = Brand::all();

        // dd($categories);

        return view('admin.create-product', [
            'categories' => $categories,
            'brands' => $brands,
        ]);
    }

    public function productsEdit(Product $product)
    {
        $categories = Category::all();
        $categories->transform(function ($category) {
            $category->parent_title = ($category->parent_id) ? Category::find($category->parent_id)->title : 'нет';
            $category->parentAttributes = new Collection;
            $category = $this->findParentAttributes($category->id, $category);
            return $category;
        });

        $product->images = Image::where("product", $product->id)->get();
        $product->inclusions = Inclusion::where("product", $product->id)->get();
        $product->attributes = Product_attribute::where("product", $product->id)
            // ->join("attributes", "product_attributes.attribute", "=", "attributes.id")
            // ->join("categories", "attributes.category", "=", "categories.id")
            // ->select("attributes.id", "attributes.name", "product_attributes.value", "categories.title as owner")
            ->get();

        // dd($product);

        $brands = Brand::all();

        return view('admin.edit-product', [
            'categories' => $categories,
            'product' => $product,
            'brands' => $brands,
        ]);
    }


    public function categories(Request $request)
    {
        $categories = Category::select();
        $treeCategories = Category::all();
        $categories = $this->filter($categories, $request)->get();

        $categories->transform(function ($category) {
            $category->parent_title = ($category->parent_id) ? Category::find($category->parent_id)->title : 'нет';
            return $category;
        });

        $treeCategories->transform(function ($category) {
            $category = $this->buildChildTree($category);
            return $category;
        });

        $treeCategories = $treeCategories->reject(function ($item) {
            return $item->parent_id !== null;
        });

        return view('admin.categories', [
            'categories' => $categories,
            'treeCategories' => $treeCategories,
        ]);
    }

    public function categoriesCreate()
    {
        $categories = Category::all();
        $categories->transform(function ($item) {
            $item->attributes = Attribute::where("category", $item->id)->get();
            return $item;
        });

        return view('admin.create-category', [
            'categories' => $categories,
        ]);
    }

    public function categoriesEdit($category)
    {
        $category = Category::find($category);
        $category->attributes = Attribute::where("category", $category->id)->get();

        $categories = Category::all();
        $categories->transform(function ($item) {

            $item->parentAttributes = new Collection;
            $item = $this->findParentAttributes($item->id, $item);

            return $item;
        });

        $category->childList = new Collection();
        $category = $this->buildChildList($category, $category);

        foreach ($categories as $key => $categ) {
            if ($categ->id == $category->id) $categories->forget($key);
            foreach ($category->childList as $thisCateg) {
                if ($categ->id == $thisCateg->id) {
                    $categories->forget($key);
                    break;
                }
            }
        }

        return view('admin.create-category', [
            'thisCategory' => $category,
            'categories' => $categories,
        ]);
    }



    public function brands(Request $request)
    {
        $brands = Brand::select();
        $brands = $this->filter($brands, $request)->get();
        return view('admin.brands', [
            'brands' => $brands,
        ]);
    }


    public function orders(Request $request)
    {
        $orders = Order::join("transactions", "orders.transaction", "=", "transactions.id")
        ->select('orders.*', 'transactions.price');
        $orders = $this->filter($orders, $request)->get();
        // dd($orders);

        return view('admin.orders', [
            'orders' => $orders,
        ]);
    }

    public function orderInfo(Order $order)
    {
        $order->transaction = Transaction::find($order->transaction);
        $products = Order_product::where("order_id", $order->id)->get();
        $order->user = User::find($order->user);
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

        // dd($order);

        return view('admin.order-info', [
            'order' => $order,
        ]);
    }



    public function transactions(Request $request)
    {
        $transactions = Transaction::select();
        $transactions = $this->filter($transactions, $request)->get();
        return view('admin.transactions', [
            'transactions' => $transactions,
        ]);
    }

    public function users(Request $request)
    {
        $users = User::select();
        $users = $this->filter($users, $request)->get();
        return view('admin.users', [
            'users' => $users,
        ]);
    }


    // -- КАСТОМНЫЕ ФУНКЦИИ ПОМОЩНИКИ

    function buildChildList($category, $item)
    {
        $children = Category::where("parent_id", $item->id)->get();
        foreach ($children as $child) {
            $category->childList->push($child);
            $this->buildChildList($category, $child);
        }
        return $category;
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

    function findParentAttributes($idParentCategory, $category)
    {
        $parentCategory = Category::find($idParentCategory);
        while ($parentCategory) {
            $attributes = Attribute::where('category', $parentCategory->id)->get();
            foreach ($attributes as $attr) {
                $attr->owner = $parentCategory->title;
                $category->parentAttributes->push($attr);
            }
            $parentCategory = Category::find($parentCategory->parent_id);
        }
        return $category;
    }

    function filter(Object $list, Request $request): Object
    {
        $request->flash();
        foreach ($request->input() as $key => $value) {
            if ($key === "_token") continue;
            if ($value === null) continue;
            if (str_contains($key, "id")) {
                $list->where(str_replace("_", ".", $key), $value);
                continue;
            }
            $list->where(str_replace("_", ".", $key), "like", "%{$value}%");
        }
        return $list->orderByDesc('id');
    }
}
