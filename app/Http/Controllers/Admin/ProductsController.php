<?php

namespace App\Http\Controllers\Admin;

use App\Brand;
use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Manufacturer;
use App\Product;
use App\Stock;
use App\Store;
use App\UnitOfMeasurement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
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
            $products = Product::where('name', 'LIKE', "%$keyword%")
                //->orWhere('brand_id', 'LIKE', "%$keyword%")
                //->orWhere('created_by', 'LIKE', "%$keyword%")
                //->orWhere('category_id', 'LIKE', "%$keyword%")
                ->orWhere('code', 'LIKE', "%$keyword%")
                //->orWhere('image', 'LIKE', "%$keyword%")
                ->orWhere('cost_price', 'LIKE', "%$keyword%")
                //->orWhere('unit_of_measurement_id', 'LIKE', "%$keyword%")
                //->orWhere('description', 'LIKE', "%$keyword%")
                //->orWhere('is_active', 'LIKE', "%$keyword%")
                //->orWhere('wholesale_min_quantity', 'LIKE', "%$keyword%")
                //->orWhere('retail_price', 'LIKE', "%$keyword%")
                //->orWhere('whole_sale_price', 'LIKE', "%$keyword%")
                //->orWhere('remark', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $products = Product::latest()->paginate($perPage);
        }

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $brands = Brand::select('id', 'name')->get()->pluck('name', 'id')->prepend('--Select Brand--', '');
        $manufacturers = Manufacturer::select('id', 'name')->get()->pluck('name', 'id')->prepend('--Product--', '');
        $categories = Category::select('id', 'name')->get()->pluck('name','id')->prepend('--Select Category--', '');
        $stores = Store::select('id', 'name')->get()->pluck('name','id');
$units = UnitOfMeasurement::select('id', 'name', 'label')->get()->pluck('label','id')->prepend('--Select Unit of Measurement--', '');
        return view('admin.products.create', compact('brands', 'manufacturers', 'categories', 'units', 'stores'));
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
        //dd($request->all());
        $this->validate($request, [
			'name' => 'required',
			//'brand_id' => 'required',
			'stores' => 'required',
			'category_id' => 'required',
			'cost_price' => 'required',
			//'unit_of_measurement_id' => 'required',
			//'description' => 'required',
			'wholesale_min_quantity' => 'required',
			//'retail_price' => 'required',
			//'whole_sale_price' => 'required',
		]);
        $requestData = $request->all();
        $manufacturer = Manufacturer::findOrFail($request->input('manufacturer_id'));
        $requestData['created_by'] = Auth::Id();
        $requestData['code'] = str_replace(' ', '-', strtolower($request->input('name'))).'-'.str_random(5).'-'.date('Y', time());
        //$requestData['name'] = $manufacturer->name . ' ' .$request->input('name');
        //$requestData['name'] = $request->input('name');

        //Calculate retail and wholesale price ffrom cust prices.
        //Note
        //Cost price input comes as a chinese currency,
        //should be converted to naira equivalent
        $product = Product::where('name', $requestData['name'])
                    ->where('category_id', $requestData['category_id'])
                    ->where('manufacturer_id', $requestData['manufacturer_id'])
                    ->first();
        if ($product) {
            return redirect('admin/products/create')->with('error_message', 'Product already exist!');

        }
        $requestData['retail_price'] = setting('1RMB') * $requestData['cost_price'] * setting('Retail-Price');   

        $requestData['whole_sale_price'] = setting('1RMB') * $requestData['cost_price'] * setting('Wholesale-Price');
        $product = Product::create($requestData);
        $stores = $request->input('stores');
        //Create new Stock of the added product
        foreach ($stores as $store) {
        $stock = new Stock;
        $stock->product_id = $product->id;
        $stock->store_id = $store;
        $stock->quantity_in_hand = $request->input('quantity_in_hand');
        $stock->re_order_quantity = $request->input('re_order_quantity');
        $stock->save();
        }



        return redirect('admin/products')->with('flash_message', 'Product was successfully added!');
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
        $product = Product::findOrFail($id);

        return view('admin.products.show', compact('product'));
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
        $product = Product::findOrFail($id);

        //$brands = Brand::select('id', 'name')->get()->pluck('name', 'id')->prepend('--Select Brand--', '');
        //
        $manufacturers = Manufacturer::select('id', 'name')->get()->pluck('name', 'id')->prepend('--Product--', '');
        $categories = Category::select('id', 'name')->get()->pluck('name','id')->prepend('--Select Category--', '');
        $stores = Store::select('id', 'name')->get()->pluck('name','id')->prepend('--Select Store--', '');
         $product_stores = [];
         foreach ($product->stocks as $stock) {
             $product_stores[] = $stock->store_id;
         }
        //dd($product_stores);
// $units = UnitOfMeasurement::select('id', 'name', 'label')->get()->pluck('label','id')->prepend('--Select Unit of Measurement--', '');

        return view('admin.products.edit', compact('product', 'manufacturers', 'categories', 'stores', 'product_stores'));
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
			'name' => 'required',
			//'brand_id' => 'required',
			//'store_id' => 'required',
			'category_id' => 'required',
			'cost_price' => 'required',
			//'unit_of_measurement_id' => 'required',
			//'description' => 'required',
			//'wholesale_min_quantity' => 'required',
			//'retail_price' => 'required',
			//'whole_sale_price' => 'required',
			'remark' => 'required'
		]);
        $requestData = $request->all();
        $requestData['code'] = str_replace(' ', '-', strtolower($request->input('name'))).'-'.str_random(5).'-'.date('Y', time());

        $product = Product::findOrFail($id);

        $requestData['retail_price'] = setting('1RMB') * $requestData['cost_price'] * setting('Retail-Price');   

        $requestData['whole_sale_price'] = setting('1RMB') * $requestData['cost_price'] * setting('Wholesale-Price');

        $product->update($requestData);

        //Feature for updates on multiple shops will be review later.
        //Create new Stock of the added product
        // $stock = Stock::where('product_id', $product->id)->first();
        // $stock->quantity_in_hand = $request->input('quantity_in_hand');
        // $stock->re_order_quantity = $request->input('re_order_quantity');
        // $stock->save();
        return redirect('admin/products')->with('flash_message', 'Product was successfully updated!');
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
        Product::destroy($id);

        return redirect('admin/products')->with('flash_message', 'Product deleted!');
    }

    public function low_product(Request $request)
    {
        return view('admin.products.low-product');
    }
}
