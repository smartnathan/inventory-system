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
        $stocks = Stock::whereRaw('quantity_in_hand > re_order_quantity')->where('store_id', Auth::user()->store_id)->get();
        return view('admin.sales.create', compact('customers', 'stocks'));
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
			//'customer_id' => 'required',
			'remark' => 'required'
		]);
        $requestData = $request->all();
$requestData['created_by'] = Auth::Id();
$requestData['code'] = str_random('4').'-'.mt_rand(111,999).'-'.date('Y-m-d', time());
        //dd($requestData);
        if ($requestData['customer_id'] == null) {
            $requestData['customer_id'] = 2;
        }

        
        $sale = Sale::create($requestData);
        

        $x = 0;
        foreach ($requestData['product_id'] as $item) {
            $content = explode(',', $item);
            $product_id = $content[0];
            $stock_id = $content[1];

        $product = Product::findOrFail($product_id);

            if ($requestData['quantity'][$x] >= $product->wholesale_min_quantity) {
            $requestData['total_price'] = $product->whole_sale_price * $requestData['quantity'][$x];
            $requestData['price_type'] = "Wholesale";
        } else {
            $requestData['total_price'] = $product->retail_price * $requestData['quantity'][$x];
            $requestData['price_type'] = "Retail";
        }
            $order = new Order;
            $order->sale_id = $sale->id;
            $order->product_id = $product_id;
            $order->quantity = $requestData['quantity'][$x];
            $order->is_paid = $requestData['is_paid'][$x];
            $order->total_price = $requestData['total_price'];
            $order->price_type = $requestData['price_type'];
            $order->code = str_random(11);
            $order->save();

            $stock = Stock::findOrFail($stock_id);
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

    public function invoice_print($id)
    {
        $total = 0;
        $sale = Sale::findOrFail($id);
        return view('admin.sales.invoice-print', compact('sale', 'total'));
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
        abort('419');
        
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
