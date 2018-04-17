<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\User;
use App\Station;
use Auth;
use Spatie\Permission\Models\Role;
use Session;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Validator;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    protected $title;

    public function __construct()
    {
        //$this->middleware(['auth', 'isAdmin']); //isAdmin middleware lets only users with a //specific permission permission to access these resources
        $this->middleware(['auth']);
        $this->title = "Users";
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = $this->title;
        $users = User::all();
        $roles = Role::select('id', 'name')->where("id", "!=", ROOT)->get();

        return view('users.index', compact('title', 'users', 'roles'));
    }

    /**
     * Get datatables grid data
     * @param Request $request
     * @return type
     */
    public function grid(Request $request)
    {
        return datatables(
            DB::table('users')
                ->leftJoin('users AS u2', 'users.created_by', '=', 'u2.id')
                ->leftJoin('users AS u3', 'users.updated_by', '=', 'u3.id')
                ->leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->select([
                    "users.id",
                    "users.name",
                    "users.email",
                    "users.first_name",
                    "users.last_name",
                    DB::raw("GROUP_CONCAT(roles.id) AS role_ids"),
                    DB::raw("GROUP_CONCAT(roles.name) AS role"),
                    DB::raw("DATE_FORMAT(users.created_at,'%d-%m-%Y') AS created_at"),
                    DB::raw("DATE_FORMAT(users.updated_at,'%d-%m-%Y') AS updated_at"),
                    DB::raw("CONCAT(u2.first_name,' ',u2.last_name) AS created_by"),
                    DB::raw("CONCAT(u3.first_name,' ',u3.last_name) AS updated_by"),
                    DB::raw("(users.id +1) AS action")
                ])->orderBy('name', 'ASC')->groupBy(['users.id']))->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Get all roles and pass it to the view
        $roles = Role::get();
        //$stations = Station::where('status',ACTIVE)->pluck('office_name','id');

        return view('users.create', compact('roles', 'stations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
                'name' => 'required|unique:permissions|max:120',
                'first_name' => 'required|max:30',
                'last_name' => 'required|max:30',
                'email' => 'email|unique:users',
                'password' => 'required|min:6|confirmed',
            ]
        );

        if ($validator->passes()) {

            $result = true;

            DB::transaction(function () use ($request, $result) {
                try {

                    $user = new User();
                    $user->name = $request->name;
                    $user->email = $request->email;
                    $user->first_name = ucfirst($request->first_name);
                    $user->last_name = ucfirst($request->last_name);
                    $user->password = bcrypt($request->password);
                    $user->created_by = Auth::user()->id;
                    $user->created_at = Carbon::now();
                    $user->save();

                    $roles = $request->roles;

                    if (isset($roles)) {

                        foreach ($roles as $role) {
                            $role_r = Role::where('id', '=', $role)->firstOrFail();
                            $user->assignRole($role_r);
                        }
                    }

                } catch (\Exception $e) {
                    $result = false;
                }
            });

            if ($result) {
                return response()->json(array("type" => "success", "text" => "Created user successfully"), 200);
            } else {
                return response()->json(array("type" => "error", "text" => "Creating user failed!"), 200);
            }

        } else {

            if ($request->ajax()) {
                return response()->json(array(
                    'success' => false,
                    'message' => 'There are incorect values in the form!',
                    'errors' => $validator->getMessageBag()->toArray()
                ), 422);
            }

            $this->throwValidationException(
                $request, $validator
            );
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect('users');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id); //Get user with specified id
        $roles = Role::get(); //Get all roles

        return view('users.edit', compact('user', 'roles')); //pass user and roles data to view
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


        $validator = Validator::make($request->all(), [
                'name' => 'required|unique:permissions|max:120',
                'first_name' => 'required|max:30',
                'last_name' => 'required|max:30',
                'email' => ['required', Rule::unique('users')->ignore($id)]
            ]
        );

        if ($validator->passes()) {

            $result = true;

            DB::transaction(function () use ($id, $request, $result) {
                try {

                    $user = User::findOrFail($id);

                    $user->name = $request->name;
                    $user->email = $request->email;
                    $user->first_name = ucfirst($request->first_name);
                    $user->last_name = ucfirst($request->last_name);
                    $user->updated_by = Auth::user()->id;
                    $user->updated_at = Carbon::now();

                    $user->save();

                    $roles = $request->roles;

                    if (isset($roles)) {
                        $user->roles()->sync($roles);
                    } else {
                        $user->roles()->detach();
                    }

                } catch (\Exception $e) {
                    $result = false;
                }
            });

            if ($result) {
                return response()->json(array("type" => "success", "text" => "Updated user successfully"), 200);
            } else {
                return response()->json(array("type" => "error", "text" => "Updating user failed!"), 200);
            }

        } else {

            if ($request->ajax()) {
                return response()->json(array(
                    'success' => false,
                    'message' => 'There are incorect values in the form!',
                    'errors' => $validator->getMessageBag()->toArray()
                ), 422);
            }

            $this->throwValidationException(
                $request, $validator
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Find a user with a given id and delete
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')
            ->with('flash_message', 'User successfully deleted.');
    }

    public function updatePassword()
    {
        return view('users.change_password');
    }

    public function changePassword(Request $request)
    {
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
        } else {
            return redirect('update_password')
                ->withErrors(['Incorrect current password']);
        }
    }

}
