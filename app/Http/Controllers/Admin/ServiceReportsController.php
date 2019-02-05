<?php

namespace App\Http\Controllers\Admin;

use App\Customer;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Service;
use App\ServiceReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceReportsController extends Controller
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
            $servicereports = ServiceReport::where('created_by', 'LIKE', "%$keyword%")
                ->orWhere('service_id', 'LIKE', "%$keyword%")
                ->orWhere('customer_id', 'LIKE', "%$keyword%")
                ->orWhere('extra_charges', 'LIKE', "%$keyword%")
                ->orWhere('reasons', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $servicereports = ServiceReport::latest()->paginate($perPage);
        }

        return view('admin.service-reports.index', compact('servicereports'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $services = Service::select('id', 'name')->get()->pluck('name', 'id')->prepend('--Select a Service--', '');
        $customers = Customer::all();
        return view('admin.service-reports.create', compact('services', 'customers'));
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
			'service_id' => 'required'
		]);
        $requestData = $request->all();
        $requestData['created_by'] = Auth::Id();
        ServiceReport::create($requestData);

        return redirect('admin/service-reports')->with('flash_message', 'ServiceReport added!');
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
        $servicereport = ServiceReport::findOrFail($id);

        return view('admin.service-reports.show', compact('servicereport'));
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
        $servicereport = ServiceReport::findOrFail($id);
$services = Service::select('id', 'name')->get()->pluck('name', 'id')->prepend('--Select a Service--', '');
        $customers = Customer::all();
        return view('admin.service-reports.edit', compact('servicereport', 'services', 'customers'));
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
			'service_id' => 'required'
		]);
        $requestData = $request->all();

        $servicereport = ServiceReport::findOrFail($id);
        $servicereport->update($requestData);

        return redirect('admin/service-reports')->with('flash_message', 'Service Report was successfully updated!');
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
        ServiceReport::destroy($id);

        return redirect('admin/service-reports')->with('flash_message', 'ServiceReport deleted!');
    }
}
