<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

class UsersController extends Controller
{
    public function index(){
        $users  = User::paginate(5);
        return view('GestionarUsuarios.users.index',compact('users'));

    }

    public function create(){
        return view('GestionarUsuarios.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],

        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => $request->is_admin,
        ]);

        return view('GestionarUsuarios.users.create');
    }

    public function edit($user_id){
        $user = User::findOrFail($user_id);
        return view('GestionarUsuarios.users.edit',compact('user'));
    }

    public function update(Request $request, $id){
        $user = User::findOrFail($id);
        $user->fill($request->all());
        $user->save();
        return Redirect::route('admin.users')->with('status', 'profile-updated');
    }
    public function destroy($user_id){
        $user = User::find($user_id);
        $user->delete();
        return Redirect::route('admin.users');
    }
}
