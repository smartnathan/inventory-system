<?php

namespace App\Http\Controllers;

use App\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function sales(Request $request){
        // $this->authorize('view-sales');
        Carbon::setWeekStartsAt(Carbon::SUNDAY);
        $total = 0;
        $query = $request->get('search');
        if (!empty($query)){
            if ($query == 'today'){
                $date = Carbon::today();
                $orders = Order::where('created_at', '>=', $date)->orderBy('id', 'desc')->get();
                return view('admin.reports.sales', compact('orders', 'total'));
            }
            elseif ($query == 'yesterday'){
                $date = Carbon::yesterday();
                $orders = Order::where('created_at', '>=', $date)
                    ->where('created_at', '<=', Carbon::today())->orderBy('id', 'desc')->get();
                return view('admin.reports.sales', compact('orders', 'total'));
            }
            elseif ($query == 'thisweek'){
                $date = Carbon::now()->startOfWeek();
                $orders = Order::where('created_at', '>=', $date)->orderBy('id', 'desc')->get();
                return view('admin.reports.sales', compact('orders', 'total'));
            }
            elseif ($query == 'lastweek'){
                $date = Carbon::now()->subWeek()->startOfWeek();
                $orders = Order::where('created_at', '>=', $date)
                    ->where('created_at', '<=', Carbon::now()->startOfWeek())->orderBy('id', 'desc')->get();
                return view('admin.reports.sales', compact('orders', 'total'));
            }
            elseif ($query == 'thismonth'){
                $date = Carbon::now()->startOfMonth();
                $orders = Order::where('created_at', '>=', $date)->orderBy('id', 'desc')->get();
                return view('admin.reports.sales', compact('orders', 'total'));
            }
            elseif ($query == 'lastmonth'){
                $date = Carbon::now()->startOfMonth()->subMonth();
                $orders = Order::where('created_at', '>=', $date)
                    ->where('created_at', '<=', Carbon::now()->startOfMonth())->orderBy('id', 'desc')->get();
                return view('admin.reports.sales', compact('orders', 'total'));
            }
            elseif ($query == 'thisyear'){
                $date = Carbon::now()->startOfYear();
                $orders = Order::where('created_at', '>=', $date)->orderBy('id', 'desc')->get();
                return view('admin.reports.sales', compact('orders', 'total'));
            }
            elseif ($query == 'lastyear'){
                $date = Carbon::now()->startOfYear()->subYear();
                $orders = Order::where('created_at', '>=', $date)
                    ->where('created_at', '<=', Carbon::now()->startOfYear())->orderBy('id', 'desc')->get();
                return view('admin.reports.sales', compact('orders', 'total'));
            }
        }
        else {
            $orders = Order::orderBy('id', 'desc')->paginate(30);
            return view('admin.reports.sales', compact('orders', 'total'));
        }
    }
}
