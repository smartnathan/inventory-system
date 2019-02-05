<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Order;
use App\Product;
use Carbon\Carbon;
use Spatie\Activitylog\Models\Activity;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        $total = 0;
        $date = Carbon::yesterday();
        $income = Order::where('created_at', '>=', $date)->get();
        $products = Product::all();
        $orders = Order::all();
        $activity = Activity::latest()->take(9)->get();
        return view('dashboard', compact('products', 'orders', 'income', 'total', 'activity'));
    }
}
