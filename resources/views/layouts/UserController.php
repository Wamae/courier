<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Station;
use Auth;
//Importing laravel-permission models
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
//Enables us to output flash messaging
use Session;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {

    public function __construct() {
        //$this->middleware(['auth', 'isAdmin']); //isAdmin middleware lets only users with a //specific permission permission to access these resources
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //Get all users and pass it to the view
        $users = User::all();
        return view('users.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //Get all roles and pass it to the view
        $roles = Role::get();
        //$stations = Station::where('status',ACTIVE)->pluck('office_name','id');

        return view('users.create', compact('roles', 'stations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //Validate name, email and password fields
        $this->validate($request, [
            'name' => 'required|max:120',
            'email' => 'email|unique:users',
            'password' => 'required|min:3|confirmed'
        ]);

        $user = User::create([
                    'name' => $request['name'],
                    'email' => $request['email'],
                    'station' => Auth::user()->station,
                    'password' => bcrypt($request['password']),
        ]); //Retrieving only the email and password data

        $roles = $request['roles']; //Retrieving the roles field
        //Checking if a role was selected
        if (isset($roles)) {

            foreach ($roles as $role) {
                $role_r = Role::where('id', '=', $role)->firstOrFail();
                $user->assignRole($role_r); //Assigning role to user
            }
        }
        //Redirect to the users.index view and display message
        return redirect()->route('users.index')
                        ->with('flash_message', 'User successfully added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        return redirect('users');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $user = User::findOrFail($id); //Get user with specified id
        $roles = Role::get(); //Get all roles

        return view('users.edit', compact('user', 'roles')); //pass user and roles data to view
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $user = User::findOrFail($id); //Get role specified by id
        //Validate name, email and password fields  
        $this->validate($request, [
            'name' => 'required|max:120',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'required|min:6|confirmed'
        ]);
        $input = [
            'name' => $request['name'],
            'email' => $request['email'],
            'station' => $request['station'],
            'password' => bcrypt($request['password']),
        ]; //Retreive the name, email and password fields
        $roles = $request['roles']; //Retreive all roles
        $user->fill($input)->save();

        if (isset($roles)) {
            $user->roles()->sync($roles);  //If one or more role is selected associate user to roles          
        } else {
            $user->roles()->detach(); //If no role is selected remove exisiting role associated to a user
        }
        return redirect()->route('users.index')
                        ->with('flash_message', 'User successfully edited.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //Find a user with a given id and delete
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')
                        ->with('flash_message', 'User successfully deleted.');
    }

    public function updatePassword() {
        return view('users.change_password');
    }

    public function changePassword(Request $request) {
        $user = Auth::user();

        $currentPassword = $request['current_password'];
        $newPassword = $request['password'];
        //dd("1");
        $this->validate($request, [
            'current_password' => 'required|min:3',
            'password' => 'required|min:3|confirmed'
        ]);


        if ($user) {
            if (Hash::check($currentPassword, $user->password)) {
                $userId = $user->id;
                $objUser = User::where("id", $userId)->first();
                $objUser->password = Hash::make($newPassword);
                $objUser->save();

                return redirect('login')->with(Auth::logout());
            } else {
                return redirect('update_password')
                 ->withErrors(['Failed to match passwords']);
            }
        }else{
            return redirect('update_password')
                 ->withErrors(['Incorrect current password']);
        }
    }

}
