<?php

namespace App\Http\Controllers\PostControllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Order_product;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class OrderController extends Controller
{
    public function create(Request $request)
    {


        return redirect()->back();
    }
}
