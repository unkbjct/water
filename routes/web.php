<?php

use App\Http\Controllers\Api\AccountController as AccountApi;
use App\Http\Controllers\GetControllers\AccountController as AccountViews;
use App\Http\Controllers\GetControllers\AdminController as AdminViews;
use App\Http\Controllers\GetControllers\CatalogControllers as CatalogViews;
use App\Http\Controllers\GetControllers\ProductController as ProductViews;
use App\Http\Controllers\GetControllers\SingleController as SingleViews;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PostControllers\AccountController as AccountCore;
use App\Http\Controllers\PostControllers\AdminController as AdminCore;
use App\Http\Controllers\PostControllers\OrderController;
use App\Http\Controllers\PostControllers\ProductController as ProductCore;
use App\Http\Controllers\PostControllers\SingleController as SingleCore;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/information', [SingleViews::class, 'information'])->name('information');

Route::post('/feedback/create', [SingleCore::class, 'feedbackCreate'])->name('feedback.create');

Route::get('/order', [SingleViews::class, 'order'])->middleware('auth')->name('order');

Route::get('/brands', [SingleViews::class, 'brands'])->name('brands');

Route::get('/order/{transaction}/successful', [SingleViews::class, 'orderSuccessful'])->name('order.successful');

Route::group(['prefix' => 'catalog'], function () {

    // Route::get('/', []);

    Route::get('/{category}', [CatalogViews::class, 'catalog'])->name('catalog.search');
});

Route::group(['prefix' => 'products/{product}'], function () {

    Route::get('/', [ProductViews::class, 'product'])->name('product');

    Route::post('/add', [ProductCore::class, 'cartAdd'])->name('product.cart.add');

    Route::post('/remove', [ProductCore::class, 'cartRemove'])->name('product.cart.remove');

    Route::post('/review/create', [ProductCore::class, 'reviewCreate'])->name('product.review.create');
});

Route::get('/favorites', [AccountViews::class, 'favorites'])->name('account.favorites');

// Route::get('/watched', [AccountViews::class, 'watched'])->name('account.watched');

Route::group(['prefix' => 'account'], function () {

    Route::get('/login', [AccountViews::class, 'login'])->name('account.login');

    Route::get('/sign-up', [AccountViews::class, 'signUp'])->name('account.signUp');

    Route::get('/logout', [AccountViews::class, 'logout'])->middleware("auth")->name('account.logout');

    Route::get('/profile', [AccountViews::class, 'personal'])->middleware("auth")->name('account.personal');

    Route::get('/history', [AccountViews::class, 'history'])->middleware("auth")->name('account.history');
});

Route::group(['prefix' => 'admin'], function () {

    // Route::get('/products', [AdminViews::class, 'products'])->name('admin.products');

    Route::group(['prefix' => 'products'], function () {

        Route::get('/', [AdminViews::class, 'products'])->name('admin.products');

        Route::get('/create', [AdminViews::class, 'productsCreate'])->name('admin.products.create');

        Route::get('/edit/{product}', [AdminViews::class, 'productsEdit'])->name('admin.products.edit');
    });

    Route::group(['prefix' => 'categories'], function () {

        Route::get('/', [AdminViews::class, 'categories'])->name('admin.categories');

        Route::get('/create', [AdminViews::class, 'categoriesCreate'])->name('admin.categories.create');

        Route::get('/edit/{category}', [AdminViews::class, 'categoriesEdit'])->name('admin.categories.edit');
    });

    Route::group(['prefix' => 'brands'], function () {

        Route::get('/', [AdminViews::class, 'brands'])->name('admin.brands');
    });

    Route::group(['prefix' => 'orders'], function () {
        Route::get('/', [AdminViews::class, 'orders'])->name('admin.orders');

        Route::get('/{order}', [AdminViews::class, 'orderInfo'])->name('admin.orders.info');
    });

    Route::group(['prefix' => 'users'], function () {

        Route::get('/', [AdminViews::class, 'users'])->name('admin.users');
    });

    Route::group(['prefix' => 'transactions'], function () {
        Route::get('/', [AdminViews::class, 'transactions'])->name('admin.transactions');
    });
});

// PPPPAAAAAYYYYMMMEENNNTTT
Route::match(['GET', 'POST'], '/payments/callback', [PaymentController::class, 'callback'])->name('payment.callback');


Route::group(['prefix' => 'core'], function () {

    Route::post('/order/create', [OrderController::class, 'create'])->name('core.order.create');

    Route::post('/payment/create', [PaymentController::class, 'create'])->name('core.payment.create');

    Route::group(['prefix' => 'account'], function () {

        Route::post('/sign-up', [AccountCore::class, 'signUp'])->name('core.account.signUp');

        Route::post('/login', [AccountCore::class, 'login'])->name('core.account.login');

        Route::group(['prefix' => 'edit'], function () {

            Route::post('/information', [AccountCore::class, 'editInformation'])->name('core.account.edit.information');

            Route::post('/password', [AccountCore::class, 'editPassword'])->name('core.account.edit.password');
        });
    });

    Route::group(['prefix' => 'admin'], function () {

        Route::group(['prefix' => 'categories'], function () {

            Route::post('/create', [AdminCore::class, 'categoriesCreate'])->name('core.admin.categories.create');

            Route::post('/edit/{category}', [AdminCore::class, 'categoriesEdit'])->name('core.admin.categories.edit');

            Route::post('/remove/{category}', [AdminCore::class, 'categoriesRemove'])->name('core.admin.categories.remove');
        });

        Route::group(['prefix' => 'product'], function () {

            Route::post('/create', [AdminCore::class, 'productsCreate'])->name('core.admin.products.create');

            Route::post('/edit/{product}', [AdminCore::class, 'productsEdit'])->name('core.admin.products.edit');

            Route::post('/remove/{product}', [AdminCore::class, 'productsRemove'])->name('core.admin.products.remove');
        });

        Route::group(['prefix' => 'brands'], function () {
            Route::post('/create', [AdminCore::class, 'brandsCreate'])->name('core.admin.brands.create');

            Route::post('/change', [AdminCore::class, 'brandsChange'])->name('core.admin.brands.change');

            Route::post('/remove', [AdminCore::class, 'brandsRemove'])->name('core.admin.brands.remove');
        });

        Route::post('/order/{order}/change', [AdminCore::class, 'orderChange'])->name('core.admin.orders.change');

        Route::post('/user/{user}/change', [AdminCore::class, 'userChange'])->name('core.admin.user.change');
    });
});

Route::group(['prefix' => 'api'], function () {

    // Route::post('/products', function () {
    //     $products = Product::all();
    //     return $products;
    // });


    // Route::post('/products/{article}', function ($article) {
    //     $product = Product::find($article);
    //     if ($product === null) return abort(404);
    //     return $product;
    // });

    Route::group(['prefix' => 'products'], function () {
        Route::post('/', [AccountApi::class, 'products']);

        Route::post('/review', [AccountApi::class, 'review']);
        
        Route::post('/{product}', [AccountApi::class, 'productItem']);
    });

    Route::group(['prefix' => 'account'], function () {

        Route::post('/login', [AccountApi::class, 'login']);

        Route::post('/create', [AccountApi::class, 'create']);

        Route::post('/logout', [AccountApi::class, 'logout']);

        Route::post('/history', [AccountApi::class, 'history']);

        Route::post('/favorites', [AccountApi::class, 'favorites']);

        Route::post('/edit', [AccountApi::class, 'edit']);

        Route::post('/edit/password', [AccountApi::class, 'editPassword']);
    });
});
