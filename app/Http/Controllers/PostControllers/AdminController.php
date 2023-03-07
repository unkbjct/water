<?php

namespace App\Http\Controllers\PostControllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GetControllers\AdminController as GetControllersAdminController;
use App\Models\Attribute as ModelsAttribute;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Image;
use App\Models\Inclusion;
use App\Models\Product;
use App\Models\Product_attribute;
use App\Models\User;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function productsCreate(Request $request)
    {
        // dd($request->input('attributes'));

        // $request->flash();
        $product = new Product();
        $product->category = $request->input('parent');
        $product->title = $request->input('title');
        $product->description = $request->input('description');
        $product->sale = $request->input('sale');
        $product->brand = $request->input('brand');
        $product->count = $request->input('count');
        $product->price = $request->input('price');
        $product->save();

        $product->article = $request->input('parent') . "-" . $product->id;
        $product->save();

        foreach ($request->file('images') as $image) {
            $path = $image->store('img/products/', 'public');
            $newImage = new Image();
            $newImage->product = $product->id;
            $newImage->url = 'public/storage/' . $path;
            $newImage->save();
        }

        if ($request->has("inclusions")) {
            foreach ($request->input("inclusions") as $value) {
                $newInclusion = new Inclusion();
                $newInclusion->product = $product->id;
                $newInclusion->value = $value;
                $newInclusion->save();
            }
        }


        $oldAttributes = Product_attribute::where("product", $product->id)->get();

        if (sizeof($oldAttributes)) {
            foreach ($oldAttributes as $oldAttr) {
                $oldAttr->delete();
            }
        }

        if ($request->has('attributes')) {
            foreach ($request->input('attributes') as $key => $attrValue) {
                if (!$attrValue) continue;
                $newAttr = new Product_attribute();
                $newAttr->attribute = $key;
                $newAttr->product = $product->id;
                $newAttr->value = $attrValue;
                $newAttr->save();
            }
        }

        // return redirect()->back();
        return redirect()->route('admin.products');
    }


    public function productsEdit(Request $request, Product $product)
    {
        $product->category = $request->input('parent');
        $product->title = $request->input('title');
        $product->description = $request->input('description');
        $product->sale = $request->input('sale');
        $product->brand = $request->input('brand');
        $product->count = $request->input('count');
        $product->price = $request->input('price');
        $product->save();

        $product->article = $request->input('parent') . "-" . $product->id;
        $product->save();


        foreach (Image::where("product", $product->id)->get() as $img) {
            $img->delete();
        }

        foreach ($request->file('images') as $image) {
            $path = $image->store('img/products/', 'public');
            $newImage = new Image();
            $newImage->product = $product->id;
            $newImage->url = 'public/storage/' . $path;
            $newImage->save();
        }

        if ($request->has("inclusions")) {
            Inclusion::where("product", $product->id)->delete();
            foreach ($request->input("inclusions") as $value) {
                $newInclusion = new Inclusion();
                $newInclusion->product = $product->id;
                $newInclusion->value = $value;
                $newInclusion->save();
            }
        }

        if ($request->has('attributes')) {
            Product_attribute::where("product", $product->id)->delete();
            foreach ($request->input('attributes') as $key => $attrValue) {
                if (!$attrValue) continue;
                $newAttr = new Product_attribute();
                $newAttr->attribute = $key;
                $newAttr->product = $product->id;
                $newAttr->value = $attrValue;
                $newAttr->save();
            }
        }
        $product->save();
        return redirect()->route('admin.products');
    }

    public function productsRemove(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products');
    }


    public function categoriesCreate(Request $request)
    {
        $errs = [];
        $request->flash();
        // if($request->input('email') == '')

        if (Category::where('title', $request->input('titleRus'))->first()) $errs['titleRus'] = 'Данное название (русский) категории уже используется!';
        if (Category::where('title_eng', $request->input('titleEng'))->first()) $errs['titleEng'] = 'Данное название (Английский) категории уже используется!';

        if ($errs) return redirect()->back()->withErrors($errs);

        $category = new Category();
        $category->title = $request->input('titleRus');
        $category->title_eng = str_replace(" ", "-", $request->input('titleEng'));
        $category->parent_id = $request->input('parent');
        $category->depth = ($request->input('parent')) ? Category::find($request->input('parent'))->depth + 1 : 0;
        $category->save();

        if ($request->has('attributes')) {
            foreach ($request->input('attributes') as $attributeName) {
                $attribute = new ModelsAttribute();
                $attribute->category = $category->id;
                $attribute->name = $attributeName;
                $attribute->save();
            }
        }

        return redirect()->route('admin.categories');
    }

    public function categoriesEdit(Request $request, $category)
    {
        $errs = [];
        $request->flash();

        $category = Category::find($category);

        if ($category->title != $request->input('titleRus') && Category::where('title', $request->input('titleRus'))->first()) $errs['titleRus'] = 'Данное название (русский) категории уже используется!';
        if ($category->title_eng != $request->input('titleEng') && Category::where('title_eng', $request->input('titleEng'))->first()) $errs['titleEng'] = 'Данное название (Английский) категории уже используется!';

        if ($errs) return redirect()->back()->withErrors($errs);

        $category->title = $request->input('titleRus');
        $category->title_eng = $request->input('titleEng');
        $category->parent_id = $request->input('parent');
        $category->depth = ($request->input('parent')) ? Category::find($request->input('parent'))->depth + 1 : 0;
        $this->editChildren($category);
        $category->save();

        $oldAttributes = Attribute::where('category', $category->id)->get();
        $newAttributes = $request->input('attributes');


        if ($request->has('attributes')) {
            foreach ($newAttributes as $newAttr) {
                $isFounded = false;
                foreach ($oldAttributes as $oldAttr) {
                    if ($newAttr == $oldAttr->name) {
                        $isFounded = true;
                        break;
                    };
                }
                if (!$isFounded) {
                    $attribute = new Attribute();
                    $attribute->category = $category->id;
                    $attribute->name = $newAttr;
                    $attribute->save();
                }
            }

            foreach ($oldAttributes as $oldAttr) {
                $isFounded = false;
                foreach ($newAttributes as $newAttr) {
                    if ($oldAttr->name == $newAttr) {
                        $isFounded = true;
                        break;
                    };
                }
                if (!$isFounded) $oldAttr->delete();
            }
        } else {
            $oldAttributes = Attribute::where('category', $category->id)->delete();
        }



        return redirect()->route('admin.categories');
    }

    public function categoriesRemove($category)
    {
        $category = Category::find($category);

        $category->childList = new Collection();
        $category = $this->buildChildList($category, $category);
        $category->childList->push($category);

        foreach ($category->childList as $categ) {
            $products = Product::where("category", $categ->id)->get();
            foreach ($products as $prod) {
                Image::where("product", $prod->id)->delete();
                Product_attribute::where("product", $prod->id)->delete();
                $prod->delete();
            }
            ModelsAttribute::where("category", $categ->id)->delete();
            $categ->delete();
        }
        return redirect()->route('admin.categories');
    }



    public function brandsCreate(Request $request)
    {
        $brand = new Brand();
        $brand->name = $request->input('name');
        $brand->save();
        return redirect()->back();
    }

    public function brandsChange(Request $request)
    {
        $brand = Brand::find($request->input('id'));
        $brand->name = $request->input('name');
        $brand->save();
        return redirect()->back();
    }

    public function brandsRemove(Request $request)
    {
        Brand::find($request->input('id'))->delete();
        return redirect()->back();
    }


    public function orderChange(Order $order, Request $request)
    {
        $order->status = $request->input('status');
        $order->save();
        return redirect()->back()->with(['success' => 'Заказ обновлен успешно!']);
    }


    public function userChange(User $user, Request $request)
    {
        if ($user->status === $request->input('status')) return redirect()->back();
        $user->status = $request->input('status');
        $user->save();
        $status = ($request->input('status') === 'ADMIN') ? "Администратор" : "Пользователь";
        return redirect()->back()->with(['success' => "Пользователю с индетифекатором {$user->id} присвоен статус \"{$status}\""]);
    }


    // ----- КАСТОМНЫЕ ФУНКЦИИ ПОМОЩНИКИ

    function editChildren($category)
    {
        $children = Category::where("parent_id", $category->id)->get();
        // if($category->id == 9) dd(123);
        // dd($children);
        foreach ($children as $child) {
            $child->depth = $category->depth + 1;
            $child->save();
            $this->editChildren($child);
        }
    }


    public function buildChildList($category, $item)
    {
        $children = Category::where("parent_id", $item->id)->get();
        foreach ($children as $child) {
            $category->childList->push($child);
            $this->buildChildList($category, $child);
        }
        return $category;
    }
}
