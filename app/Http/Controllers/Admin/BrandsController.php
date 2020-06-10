<?php

namespace App\Http\Controllers\Admin;

use App\Brand;
use App\Manufacturer;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BrandsController extends Controller
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
            $brands = Brand::where('manufacturer_id', 'LIKE', "%$keyword%")
                ->orWhere('name', 'LIKE', "%$keyword%")
                ->orWhere('created_by', 'LIKE', "%$keyword%")
                ->orWhere('code', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $brands = Brand::latest()->paginate($perPage);
        }

        return view('admin.brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $manufacturers = Manufacturer::select('id', 'name')->get()
        ->pluck('name', 'id')
        ->prepend('--select Product--', '');
        return view('admin.brands.create', compact('manufacturers'));
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

        $requestData = $request->all();
        $requestData['created_by'] = Auth::Id();
        Brand::create($requestData);

        return redirect('admin/brands')->with('flash_message', 'Model was successfully added!');
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
        $brand = Brand::findOrFail($id);

        return view('admin.brands.show', compact('brand'));
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
        $manufacturers = Manufacturer::select('id', 'name')->get()
        ->pluck('name', 'id')
        ->prepend('--select Manufacturer--', '');
        $brand = Brand::findOrFail($id);

        return view('admin.brands.edit', compact('brand', 'manufacturers'));
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

        $requestData = $request->all();

        $brand = Brand::findOrFail($id);
        $brand->update($requestData);

        return redirect('admin/brands')->with('flash_message', 'Model was successfully updated!');
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
        Brand::destroy($id);

        return redirect('admin/brands')->with('flash_message', 'Brand deleted!');
    }
}
