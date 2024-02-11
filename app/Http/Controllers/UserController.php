<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // index
    public function index(Request $request)
    {
        // get all users with pagination
        $users = DB::table('users')
            ->when($request->input('name'), function ($query, $name) {
                $query->where('name', 'like', '%' . $name . '%')
                    ->orWhere('email', 'like', '%' . $name . '%');
            })
            ->paginate(10);
        $type_menu = 'dashboard';
        return view('pages.users.index', compact('users', 'type_menu'));
    }

    // create
    public function create()
    {
        return view('pages.users.create', ['type_menu' => 'dashboard']);
    }

    // store
    public function store(Request $request)
    {
        // validate the request
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role' => 'required|in:admin,staff,user',
        ]);

        // store the request
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make('password');
        $user->role = $request->role;
        $user->save();

        return redirect()->route('users.index')->with('success', 'User created successfully');
    }

    // show
    public function show()
    {
        return view('pages.users.show', ['type_menu' => 'dashboard']);
    }

    // edit
    public function edit($id)
    {
        $user = User::findOrfail($id);
        $type_menu = 'dashboard';
        return view('pages.users.edit', compact('user', 'type_menu'));
    }

    // update
    public function update(Request $request, $id)
    {
        // validate the request
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,id',
            'role' => 'required|in:admin,staff,user',
        ]);

        // update the request
        $user = User::findOrfail($id);
        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'role' => $request->input('role'),
        ]);

        // if password is not empty
        if ($request->password) {
            // validate the request
            $request->validate([
                'password' => 'required|min:8',
            ]);

            // update the request
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    // destroy
    public function destroy($id)
    {
        // delete the user
        $user = User::findOrfail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
}
