<?php

namespace App\Http\Controllers\Admin;

use App\Country;
use App\Manufacturer;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ManufacturersController extends Controller
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
            $manufacturers = Manufacturer::where('name', 'LIKE', "%$keyword%")
                ->orWhere('country_id', 'LIKE', "%$keyword%")
                ->orWhere('created_by', 'LIKE', "%$keyword%")
                ->orWhere('status', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $manufacturers = Manufacturer::latest()->paginate($perPage);
        }

        return view('admin.manufacturers.index', compact('manufacturers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $countries = Country::select('id', 'full_name')->get()
        ->pluck('full_name', 'id')
        ->prepend('--select country--', '');
        return view('admin.manufacturers.create', compact('countries'));
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
        Manufacturer::create($requestData);

        return redirect('admin/manufacturers')->with('flash_message', 'Product was successfully added!');
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
        $manufacturer = Manufacturer::findOrFail($id);

        return view('admin.manufacturers.show', compact('manufacturer'));
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
        $manufacturer = Manufacturer::findOrFail($id);
        $countries = Country::select('id', 'full_name')->get()
        ->pluck('full_name', 'id')
        ->prepend('--select country--', '');

        return view('admin.manufacturers.edit', compact('manufacturer', 'countries'));
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

        $manufacturer = Manufacturer::findOrFail($id);
        $manufacturer->update($requestData);

        return redirect('admin/manufacturers')->with('flash_message', 'Product was successfully updated!');
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
        Manufacturer::destroy($id);

        return redirect('admin/manufacturers')->with('flash_message', 'Product was succesfully deleted!');
    }
}
