<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{
    public function index()
    {
        return response()->json([
            'usr' => User::all()
        ]);
    }

    public function register(Request $request)
    {

        $data = $request->validate([
            'name' => 'required|string|max:128',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user
        ]);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $user = User::where('email', $data['email'])->first();
        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return response()->json(['message' => 'Invalid credentials']);
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['token' => $token, 'user' => $user]);
    }

    public function logout(Request $request)
    {
        $data['email'] = 'user2@gmail.com';
        $user = User::where('email', $data['email'])->first();
        $token = $user->tokens();
        return response()->json(['msg' => 'Logged out',  'user' => $user, 'token' => $token]);
    }


    public function loggedinUser(Request $request)
    {
        $data['email'] = 'user2@gmail.com';
        $user = User::where('email', $data['email'])->first();
        return response()->json(['msg' => 'logged in user' , 'user' => $user]);
    }
}
