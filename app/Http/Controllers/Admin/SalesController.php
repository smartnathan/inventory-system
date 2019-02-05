<?php

namespace App\Http\Controllers\Admin;

use App\Customer;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Order;
use App\Product;
use App\Sale;
use App\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            if (Auth::user()->hasRole(['admin', 'manager', 'maintenance-admin'])) {
                $sales = Sale::where('customer_id', 'LIKE', "%$keyword%")
                ->orWhere('created_by', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
            } else {
                $sales = Sale::where('customer_id', 'LIKE', "%$keyword%")->where('created_by', Auth::Id())
                ->orWhere('created_by', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
            }

        } else {
            if (Auth::user()->hasRole(['admin', 'manager', 'maintenance-admin'])) {
                $sales = Sale::latest()->paginate($perPage);
            } else {
            $sales = Sale::where('created_by', Auth::Id())->latest()->paginate($perPage);
            }
        }

        return view('admin.sales.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $customers = Customer::all();
        $products = Product::select('id', 'name', 'brand_id')->get();
        return view('admin.sales.create', compact('customers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
    $this->validate($request, [
			'customer_id' => 'required',
			'remark' => 'required'
		]);
        $requestData = $request->all();
$requestData['created_by'] = Auth::Id();
$requestData['code'] = str_random('4').'-'.mt_rand(111,999).'-'.date('Y-m-d', time());
        $sale = Sale::create($requestData);
        $x = 0;
        foreach ($requestData['product_id'] as $item) {
            $order = new Order;
            $order->sale_id = $sale->id;
            $order->product_id = $item;
            $order->quantity = $requestData['quantity'][$x];
            $order->is_paid = $requestData['is_paid'][$x];
            $order->save();
            $stock = Stock::where('product_id', $item )->first();
            $stock->decrement('quantity_in_hand', $requestData['quantity'][$x]);
            $x++;
        }

        //Log The activity
        $log = new Activity;
        $log->log_name = 'sales';
        $log->description = "Made sales with code number {$sale->code} to ";
        $log->causer_id = Auth::Id();
        $log->subject_type = $sale->customer->name;
        $log->causer_type = 'App\User';
        $log->save();
        return redirect('admin/sales')->with('flash_message', 'Sale was successfully made!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $total = 0;
        $sale = Sale::findOrFail($id);
        return view('admin.sales.show', compact('sale', 'total'));
    }

    public function invoice($id)
    {
        $total = 0;
        $sale = Sale::findOrFail($id);
        return view('admin.sales.invoice', compact('sale', 'total'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $sale = Sale::findOrFail($id);

        return view('admin.sales.edit', compact('sale'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
			'customer_id' => 'required',
			'remark' => 'required'
		]);
        $requestData = $request->all();

        $sale = Sale::findOrFail($id);
        $sale->update($requestData);

        return redirect('admin/sales')->with('flash_message', 'Sale updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Sale::destroy($id);

        return redirect('admin/sales')->with('flash_message', 'Sale deleted!');
    }
}
