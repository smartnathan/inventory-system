<?php

namespace App\Http\Controllers\Admin;

use App\Brand;
use App\Stock;

use App\Store;
use App\Product;
use App\Category;
use App\Http\Requests;
use App\UnitOfMeasurement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
                ->orWhere('brand_id', 'LIKE', "%$keyword%")
                ->orWhere('created_by', 'LIKE', "%$keyword%")
                ->orWhere('category_id', 'LIKE', "%$keyword%")
                ->orWhere('code', 'LIKE', "%$keyword%")
                ->orWhere('image', 'LIKE', "%$keyword%")
                ->orWhere('cost_price', 'LIKE', "%$keyword%")
                ->orWhere('unit_of_measurement_id', 'LIKE', "%$keyword%")
                ->orWhere('description', 'LIKE', "%$keyword%")
                ->orWhere('is_active', 'LIKE', "%$keyword%")
                ->orWhere('wholesale_min_quantity', 'LIKE', "%$keyword%")
                ->orWhere('retail_price', 'LIKE', "%$keyword%")
                ->orWhere('whole_sale_price', 'LIKE', "%$keyword%")
                ->orWhere('remark', 'LIKE', "%$keyword%")
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
        $categories = Category::select('id', 'name')->get()->pluck('name','id')->prepend('--Select Category--', '');
        $stores = Store::select('id', 'name')->get()->pluck('name','id')->prepend('--Select Store--', '');
$units = UnitOfMeasurement::select('id', 'name', 'label')->get()->pluck('label','id')->prepend('--Select Unit of Measurement--', '');
        return view('admin.products.create', compact('brands', 'categories', 'units', 'stores'));
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
			'name' => 'required',
			'brand_id' => 'required',
			'store_id' => 'required',
			'category_id' => 'required',
			'cost_price' => 'required',
			'unit_of_measurement_id' => 'required',
			'description' => 'required',
			'is_active' => 'required',
			'wholesale_min_quantity' => 'required',
			'retail_price' => 'required',
			'whole_sale_price' => 'required',
		]);
        $requestData = $request->all();
        $brand = Brand::findOrFail($request->input('brand_id'));
        $requestData['created_by'] = Auth::Id();
        $requestData['code'] = str_replace(' ', '-', strtolower($request->input('name'))).'-'.str_random(5).'-'.date('Y', time());
        $requestData['name'] = $brand->manufacturer->name . ' ' .$request->input('name');
        $product = Product::create($requestData);
        //Create new Stock of the added product
        $stock = new Stock;
        $stock->product_id = $product->id;
        $stock->quantity_in_hand = $request->input('quantity_in_hand');
        $stock->re_order_quantity = $request->input('re_order_quantity');
        $stock->save();



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

        $brands = Brand::select('id', 'name')->get()->pluck('name', 'id')->prepend('--Select Brand--', '');
        $categories = Category::select('id', 'name')->get()->pluck('name','id')->prepend('--Select Category--', '');
        $stores = Store::select('id', 'name')->get()->pluck('name','id')->prepend('--Select Store--', '');
$units = UnitOfMeasurement::select('id', 'name', 'label')->get()->pluck('label','id')->prepend('--Select Unit of Measurement--', '');

        return view('admin.products.edit', compact('product', 'brands', 'categories', 'stores', 'units'));
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
			'brand_id' => 'required',
			'store_id' => 'required',
			'category_id' => 'required',
			'cost_price' => 'required',
			'unit_of_measurement_id' => 'required',
			'description' => 'required',
			'wholesale_min_quantity' => 'required',
			'retail_price' => 'required',
			'whole_sale_price' => 'required',
			'remark' => 'required'
		]);
        $requestData = $request->all();
        $requestData['code'] = str_replace(' ', '-', strtolower($request->input('name'))).'-'.str_random(5).'-'.date('Y', time());

        $product = Product::findOrFail($id);
        $product->update($requestData);

        //Create new Stock of the added product
        $stock = Stock::where('product_id', $product->id)->first();
        $stock->quantity_in_hand = $request->input('quantity_in_hand');
        $stock->re_order_quantity = $request->input('re_order_quantity');
        $stock->save();
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
