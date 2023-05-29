<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Image;
use App\Models\Inclusion;
use App\Models\Order;
use App\Models\Order_product;
use App\Models\Product;
use App\Models\Product_attribute;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function login(Request $request)
    {
        $errs = [];
        if (!$request->input('email')) $errs['email'] = 'Логин обязательное поле!';
        if (!$request->input('passwd')) $errs['passwd'] = 'Пароль обязательное поле!';
        if ($errs) return ['status' => 'error', 'data' => $errs];

        if (Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('passwd')
        ])) {
            return [
                'status' => 'success',
                'data' => [
                    'user' => Auth::user()
                ]
            ];
        } else {
            return [
                'status' => 'error',
                'data' => [
                    'user' => 'Пользователь не найден!'
                ]
            ];
        }
    }


    public function create(Request $request)
    {
        $errs = [];
        $request->flashOnly(['email', 'name', 'surname']);
        if (!$request->input('email')) $errs['email'] = 'Почта обязательное поле!';
        if (!$request->input('name')) $errs['name'] = 'Имя обязательное поле!';
        if (!$request->input('surname')) $errs['surname'] = 'Фамилия обязательное поле!';
        if (!$request->input('passwd')) $errs['passwd'] = 'Пароль обязательное поле!';
        if (!$request->input('confirmPasswd')) $errs['confirmPasswd'] = 'Подтверждение пароля обязательное поле!';
        if ($request->input('confirmPasswd') != $request->input('passwd')) $errs['passwd'] = 'Пароли не совпадают!';

        if (sizeof(User::where('email', $request->input('email'))->get())) $errs['email'] = 'Данная почта уже используется!';

        if ($errs) return ['status' => 'error', 'data' => $errs];

        $user = new User();
        $user->email = $request->input('email');
        $user->name = $request->input('name');
        $user->surname = $request->input('surname');
        $user->password = $request->input('passwd');
        $user->save();

        if (Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('passwd')
        ])) {
            return [
                'status' => 'success',
                'data' => [
                    'user' => Auth::user()
                ]
            ];
        }
    }

    public function logout()
    {
        Auth::logout();
    }

    public function history(Request $request)
    {
        $orders = Order::where("user", $request->input('id'))->orderByDesc('id')->get();
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
        return [
            'status' => 'success',
            'data' => [
                'orders' => $orders,
            ]
        ];
    }

    public function favorites(Request $request)
    {
        // if () return view('account.favorites');
        $produts = Product::whereIn("id", $request->input('favorites'))->get();
        $produts->transform(function ($prod) {
            $prod->images = Image::where("product", $prod->id)->first()->url;
            return $prod;
        });

        return [
            'status' => 'success',
            'data' => [
                'products' => $produts,
            ]
        ];
    }

    public function edit(Request $request)
    {
        $errs = [];
        // if($request->input('email') == '')
        $user = User::find($request->input('id'));

        if ($user->email != $request->input('email') && User::where('email', $request->input('email'))->first()) $errs['email'] = 'Данная почта уже кем-то используется!';

        if ($errs) {
            return [
                'status' => 'error',
                'data' => [$errs]
            ];
        };

        $user->email = $request->input('email');
        $user->name = $request->input('name');
        $user->surname = $request->input('surname');
        $user->save();
        return [
            'status' => 'success',
            'message' => 'Изменения сохранены!',
            'data' => [
                'user' => $user,
            ]
        ];
    }


    public function editPassword(Request $request)
    {
        $errs = [];
        $user = User::find($request->input('id'));
        if (!Hash::check($request->input('oldPassword'), $user->password)) $errs['oldPassword'] = 'Старый пароль не верный!';
        if ($request->input('newPassword') != $request->input('confirmNewPassword')) $errs['confirmPassword'] = 'Пароли не совпадают!';

        if ($errs) {
            return [
                'status' => 'error',
                'data' => [$errs]
            ];
        }

        $user->password = $request->input('newPassword');
        $user->save();

        return [
            'status' => 'success',
            'message' => 'Изменения сохранены!',
            'data' => []
        ];
    }

    public function products(Request $request)
    {
        $request->flash();

        $products = Product::select();

        if ($request->has('category') && $request->input('category')) {
            $category = Category::find($request->input('category'));
            $thisCategory = $category;
            $listCategories = new Collection();
            $listCategories = $this->buildChildList($listCategories, $category);
            $idListCategories = [];
            array_push($idListCategories, $category->id);
            foreach ($listCategories as $item) {
                array_push($idListCategories, $item->id);
            }
            $products = Product::whereIn("category", $idListCategories);
        }

        if ($request->has("isHave")) $products->where("count", ">", 0);
        if ($request->has("isSale")) $products->where("sale", ">", 0);
        if ($request->has("price-from") && $request->input("price-from")) $products->where("price", ">=", $request->input("price-from"));
        if ($request->has("price-to") && $request->input("price-to")) $products->where("price", "<=", $request->input("price-to"));
        if ($request->has('brands')) $products->whereIn("brand", $request->input('brands'));
        if ($request->has('sort') && $request->input('sort')) $products->orderBy(explode(":", $request->input('sort'))[0], explode(":", $request->input('sort'))[1]);
        if ($request->has('title') && $request->input('title')) $products->where("title", "like", "%{$request->input('title')}%");

        $products = $products->get();


        $products->transform(function ($prod) {
            $prod->images = Image::where("product", $prod->id)->get();
            return $prod;
        });

        $treeCategories = Category::all();
        $treeCategories->transform(function ($category) {
            $category = $this->buildChildTree($category);
            return $category;
        });
        $treeCategories = $treeCategories->reject(function ($item) {
            return $item->parent_id !== null;
        });

        $brands = Brand::all();
        return [
            'status' => 'success',
            'message' => 'Изменения сохранены!',
            'data' => [
                'products' => $products,
                'categoryTree' => $treeCategories,
                'brands' => $brands,
            ]
        ];
    }

    public function productItem(Product $product)
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
        return [
            'status' => 'success',
            'message' => 'Изменения сохранены!',
            'data' => [
                'product' => $product,
                'reviews' => $reviews,
                'categoryList' => $categoryList,
                'watchedList' => $watchedList,
                'brandList' => $brandList,
            ]
        ];
    }


    public function review(Request $request)
    {
        $review = new Review();
        $review->user = $request->userId;
        $review->product = $request->productId;
        $review->rating = $request->input('score');
        $review->advantages = $request->input('pluses');
        $review->flaw = $request->input('minuses');
        $review->comment = $request->input('comment');
        $review->save();

        $product = Product::find($request->productId);

        $sum = $product->raiting_sum + $request->input('score');
        $count = $product->raiting_count + 1;

        $product->rating_count = $count;
        $product->rating_sum = $sum;
        $product->rating = (float)($sum / $count);
        $product->save();

        return response([
            'status' => 'success',
            'message' => 'Отзыв добавлен успешно!',
            'data' => []
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
