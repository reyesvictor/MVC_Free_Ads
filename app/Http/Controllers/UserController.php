<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\User;


class UserController extends Controller
{

    public function __construct()
    {
        if ( Route::getCurrentRoute()->getActionName() == 'registerUser' ) {
            $this->middleware('auth');
        }
    }

    public function registerUser()
    {
        if ( Auth::check() ) {
            return view('index');
        } else {
            return view('auth.register');
        }
    }

    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function edit(User $user)
    {
        $user = Auth::user();
        return view('users.edit', compact('user'));
    }

    public function update(User $user)
    {
        if (Auth::user()->email == request('email')) {
            $this->validate(request(), [
                'name' => 'required',
                //  'email' => 'required|email|unique:users',
                'password' => 'required|min:6|confirmed'
            ]);
            $user->name = request('name');
            // $user->email = request('email');
            $user->password = bcrypt(request('password'));
            $user->save();
            return back();
        } else {
            $this->validate(request(), [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6|confirmed'
            ]);
            $user->name = request('name');
            $user->email = request('email');
            $user->password = bcrypt(request('password'));
            $user->save();
            return back();
        }
    }

    public function delete()
    {
        $user = Auth::user()->id;
        $user = User::find($user);
    }
}
