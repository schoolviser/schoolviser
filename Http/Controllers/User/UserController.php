<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;
use App\Models\Employee\Employee;
use Delgont\Auth\Models\Role;

use Carbon\Carbon;

class UserController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Recently active users - to be used

        $users = User::employee()->with(['usertype','role'])->where('id', '!=', auth()->user()->id)->paginate();
        return (request()->expectsJson()) ? response()->json($users, 200) : view('dashboard.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employees = Employee::whereDoesntHave('user')->get();
        $roles = Role::where('name', '!=', 'master')->get();

        $users = User::with(['usertype','role'])->where('id' , '!=', auth()->user()->id)->latest()->get();

        return view('dashboard.users.create', compact('employees', 'users', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|max:25|confirmed',
            'user_id' => 'required',
            'role_id' => 'required',
        ],[
            'role_id' => 'Assign the user a role'
        ]);

        $employee = Employee::whereId($request->user_id)->first();

        $employee->user()->create([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'password' => bcrypt($request->password)
        ]);

        return ($request->expectsJson()) ? response()->json([
            'message' => 'Created user successfully ...',
            'success' => true
        ], 200) :back()->withInput()->with('created', 'User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::with(['usertype','role'])->findOrFail($id);

        return (request()->expectsJson()) ? response()->json($user, 200) : view('dashboard.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateUsername(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->name = $request->username;
        $user->save();

        return ($request->expectsJson()) ? response()->json([
            'message' => 'Username updated successfully',
            'success' => true
        ], 200) : back()->withInput()->with('updated', 'Username updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function block($id)
    {
        User::destroy($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function suspend($id)
    {
        User::destroy($id);
    }


    public function changePassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|min:6|max:25|confirmed',
        ]);

        $user = User::findOrFail($id);

        $user->password = bcrypt($request->password);

        return back()->withInput()->with('updated', 'Password updated successfully ...');
    }
}
