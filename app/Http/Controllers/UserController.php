<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use App\User;


class UserController extends Controller
{

    public function __construct()
    {
        if (Route::getCurrentRoute()->getActionName() == 'registerUser') {
            $this->middleware('auth');
        }
    }

    public function registerUser()
    {
        if (Auth::check()) {
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
        //CETTE LIGNE
        $user = Auth::user();
        $emailstored = Auth::user()->email;

        if (Auth::user()->email == request()->email) {
            $this->validate(request(), [
                'name' => 'required',
                'password' => 'required|min:6|confirmed'
            ]);
        } else {
            $this->validate(request(), [
                'name' => 'required',
                'email' => 'email|unique:users',
                'password' => 'required|min:6|confirmed'
            ]);
        }
        $user->name = request('name');
        $user->email = request('email');
        $user->password = bcrypt(request('password'));
        $user->save();
        if ($emailstored !== $user->email) {
            return redirect()
                ->route('users.edit')
                ->with('success', 'Your user email has been updated: ' . $user->email);
        } else {
            return redirect()
                ->route('users.edit')
                ->with('success', 'Your information has been updated');
        }
    }

    public function delete()
    {
        $id = Auth::user()->id;
        $users = User::findOrFail($id);
        $users->delete();
        return Redirect::route('index')
            ->with('delete', 'Your account has been deleted.');
    }
}
