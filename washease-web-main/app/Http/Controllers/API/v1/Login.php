<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Login extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid login details',
            ], 401);
        }

        return response()->json([
            'token' => Auth::user()->createToken('API Token')->plainTextToken,
            'message' => 'Login successful',
            'type' => 'Bearer',
            'role' => Auth::user()->role,
            'user_id' => Auth::user()->id,
            'isAuthenticated' => true
        ]);
    }

    public function loginWeb(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            // Retrieve the authenticated user
            $user = Auth::user();

            // Generate a bearer token for the user
            $bearerToken = $user->createToken('Personal Access Token')->plainTextToken;

            // Store the bearer token in the session
            $request->session()->put('bearerToken', $bearerToken);

            // Pass the bearer token to a blade view
            return view('customers.pages.token')->with('bearerToken', $bearerToken);
        }

        return back()->with('error', 'Invalid login details');
    }

}
