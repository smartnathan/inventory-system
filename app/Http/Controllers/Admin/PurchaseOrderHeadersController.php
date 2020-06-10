<?php

namespace App\Http\Controllers\Admin;

use App\Stock;
use App\Product;

use App\Supplier;
use App\Http\Requests;
use App\PurchaseOrderLine;
use App\PurchaseOrderHeader;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PurchaseOrderHeadersController extends Controller
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
            $purchaseorderheaders = PurchaseOrderHeader::where('supplier_id', 'LIKE', "%$keyword%")
                ->orWhere('date_purchased', 'LIKE', "%$keyword%")
                ->orWhere('total_amount', 'LIKE', "%$keyword%")
                ->orWhere('created_by', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $purchaseorderheaders = PurchaseOrderHeader::latest()->paginate($perPage);
        }

        return view('admin.purchase-order-headers.index', compact('purchaseorderheaders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $suppliers = Supplier::select('id', 'name')->get()->pluck('name', 'id')->prepend('--Select Supplier--', '');
        $products = Product::select('id', 'name')->get()->pluck('name', 'id')->prepend('--Select Product--', '');
        return view('admin.purchase-order-headers.create', compact('products', 'suppliers'));
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
			//'supplier_id' => 'required',
			//'date_purchased' => 'required',
			//'total_amount' => 'required',
			'unit_price' => 'required',
			'quantity' => 'required',
			'product_id' => 'required'
		]);

        $requestData = $request->all();
        $requestData['created_by'] = Auth::Id();
        $requestData['total_amount'] = setting('1RMB') * $request->input('unit_price')  * $request->input('quantity');
        $purchase_order_header = PurchaseOrderHeader::create($requestData);
        $purchase_order_line = new PurchaseOrderLine;
        $purchase_order_line->purchase_order_header_id = $purchase_order_header->id;
        $purchase_order_line->product_id = $request->input('product_id');
        //$purchase_order_line->unit_price = $request->input('unit_price');
        $purchase_order_line->unit_price = setting('1RMB') * $request->input('unit_price') * setting('Retail-Price');
        $purchase_order_line->quantity = $request->input('quantity');
        $purchase_order_line->save();

//Update Quantity in hand field in Products table
$product_stock = Stock::where('product_id', $request->input('product_id'))->first();
$product_stock->increment('quantity_in_hand', $request->input('quantity'));

    /*Find and update product wholesale and retail price when re-stocked*/
        
        $product = Product::findOrFail($request->product_id);

        $product->retail_price = setting('1RMB') * $request->input('unit_price')  * setting('Retail-Price');   

        $product->whole_sale_price = setting('1RMB') * $request->input('unit_price') * setting('Wholesale-Price');

        $product->save();


        return redirect('admin/purchase-order-headers')->with('flash_message', 'Purchase Order was successfully added!');
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
        $purchaseorderheader = PurchaseOrderHeader::findOrFail($id);

        return view('admin.purchase-order-headers.show', compact('purchaseorderheader'));
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
        $suppliers = Supplier::select('id', 'name')->get()->pluck('name', 'id')->prepend('--Select Supplier--', '');
        $products = Product::select('id', 'name')->get()->pluck('name', 'id')->prepend('--Select Product--', '');
        $purchaseorderheader = PurchaseOrderHeader::findOrFail($id);

        return view('admin.purchase-order-headers.edit', compact('purchaseorderheader', 'suppliers', 'products'));
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
			'supplier_id' => 'required',
			'date_purchased' => 'required',
			'total_amount' => 'required'
		]);
        $requestData = $request->all();

        $purchaseorderheader = PurchaseOrderHeader::findOrFail($id);
        $purchaseorderheader->update($requestData);

        $purchase_order_line = PurchaseOrderLine::where('purchase_order_header_id',$purchaseorderheader->id)->first();
        $purchase_order_line->product_id = $request->input('product_id');
        $purchase_order_line->unit_price = $request->input('unit_price');
        $purchase_order_line->quantity = $request->input('quantity');
        $purchase_order_line->save();



        return redirect('admin/purchase-order-headers')->with('flash_message', 'PurchaseOrderHeader updated!');
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
        PurchaseOrderHeader::destroy($id);
PurchaseOrderLine::where('purchase_order_header_id', $id)->first()->delete();

        return redirect('admin/purchase-order-headers')->with('flash_message', 'PurchaseOrderHeader deleted!');
    }
}
