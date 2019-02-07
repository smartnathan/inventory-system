<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Role;
use App\Sale;
use App\Store;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 15;

        if (!empty($keyword)) {
            $users = User::where('name', 'LIKE', "%$keyword%")->orWhere('email', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $users = User::latest()->paginate($perPage);
        }

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        $stores = Store::select('id', 'name')->get()->pluck('name', 'id')->prepend('--Select Store--', '');
        $roles = Role::select('id', 'name', 'label')->get();
        $roles = $roles->pluck('label', 'name');
        return view('admin.users.create', compact('roles', 'stores'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return void
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => 'required',
                'email' => 'required|string|max:255|email|unique:users',
                'password' => 'required',
                'roles' => 'required'
            ]
        );

        $data = $request->except('password');
        $data['password'] = bcrypt($request->password);
        $user = User::create($data);

        foreach ($request->roles as $role) {
            $user->assignRole($role);
        }

        return redirect('admin/users')->with('flash_message', 'User added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function show($id)
    {
        $total = 0;
        $total_sale = Sale::where('created_by', $id)->get();
        $today_sale = Sale::where('created_by', $id)->where('created_at', '>=', Carbon::today())->get();
        $user = User::findOrFail($id);
        $activity_logs = Activity::where('causer_id', $id)->latest()->take(14)->get();
        if (Auth::Id() == $id || Auth::user()->hasRole(['admin', 'manager', 'maintenance-admin'])) {
            return view('admin.users.profile', compact('user', 'activity_logs', 'today_sale', 'total_sale', 'total'));
        }
        else {
            return abort(404);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function edit($id)
    {
        $roles = Role::select('id', 'name', 'label')->get();
        $roles = $roles->pluck('label', 'name');
        $stores = Store::select('id', 'name')->get()->pluck('name', 'id')->prepend('--Select Store--', '');
        $user = User::with('roles')->select('id', 'name', 'email','store_id', 'gender')->findOrFail($id);
        $user_roles = [];
        foreach ($user->roles as $role) {
            $user_roles[] = $role->name;
        }

        return view('admin.users.edit', compact('user', 'roles', 'user_roles', 'stores'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int      $id
     *
     * @return void
     */
    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'name' => 'required',
                'email' => 'required|string|max:255|email|unique:users,email,' . $id,
                'roles' => 'required'
            ]
        );

        $data = $request->except('password');
        if ($request->has('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user = User::findOrFail($id);
        $user->update($data);

        $user->roles()->detach();
        foreach ($request->roles as $role) {
            $user->assignRole($role);
        }

        return redirect('admin/users')->with('flash_message', 'User updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function destroy($id)
    {
        User::destroy($id);

        return redirect('admin/users')->with('flash_message', 'User deleted!');
    }
}
