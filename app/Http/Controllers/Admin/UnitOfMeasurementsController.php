<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\UnitOfMeasurement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UnitOfMeasurementsController extends Controller
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
            $unitofmeasurements = UnitOfMeasurement::where('name', 'LIKE', "%$keyword%")
                ->orWhere('created_by', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $unitofmeasurements = UnitOfMeasurement::latest()->paginate($perPage);
        }

        return view('admin.unit-of-measurements.index', compact('unitofmeasurements'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.unit-of-measurements.create');
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
			'label' => 'required',
		]);
        $requestData = $request->all();
        $requestData['created_by'] = Auth::Id();
        UnitOfMeasurement::create($requestData);

        return redirect('admin/unit-of-measurements')->with('flash_message', 'UnitOfMeasurement added!');
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
        $unitofmeasurement = UnitOfMeasurement::findOrFail($id);

        return view('admin.unit-of-measurements.show', compact('unitofmeasurement'));
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
        $unitofmeasurement = UnitOfMeasurement::findOrFail($id);

        return view('admin.unit-of-measurements.edit', compact('unitofmeasurement'));
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
			'name' => 'required'
		]);
        $requestData = $request->all();

        $unitofmeasurement = UnitOfMeasurement::findOrFail($id);
        $unitofmeasurement->update($requestData);

        return redirect('admin/unit-of-measurements')->with('flash_message', 'UnitOfMeasurement updated!');
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
        UnitOfMeasurement::destroy($id);

        return redirect('admin/unit-of-measurements')->with('flash_message', 'UnitOfMeasurement deleted!');
    }
}
