<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            DB::table('user_sessions')->where('user_id', $user->id)->delete();
            // Start a new session
            session()->regenerate();

            // Save the new session
            DB::table('user_sessions')->insert([
                'user_id' => $user->id,
                'session_id' => session()->getId(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $user->device_token = $request->header('User-Agent');
            $user->last_login = now();
            $user->save();
            $token = $user->createToken($request->email)->plainTextToken;
            return response()->json(
                [
                    'token' => $token,
                    'message' => 'Login successful',
                    'user' => $user,
                    'role' => $user->role,
                    'session_id' => session()->getId(),
                    'status' => 'success'
                ],
                200
            );
        }

        return response()->json(
            [
                'message' => 'Invalid credentials',
                'status' => 'failed'
            ],
            401
        );
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        $user_id = Auth::user()->id;
        $user_new = User::where('id', $user_id)->first();
        $user_new->device_token = null;
        $user_new->save();
        if (DB::table('personal_access_tokens')->where('tokenable_id', $user_id)->delete()) {
            return response([
                'message' => 'Logout Successful',
                'status' => 'success'
            ], 200);
        }
    }

    public function checkSession()
    {
        $user = Auth::user();
        if ($user) {
            return response([
                'status' => 'success',
                'message' => 'Session is valid',
                'user' => $user
            ], 200);
        } else {
            return response([
                'status' => 'error',
                'message' => 'Invalid session'
            ], 401);
        }
    }

    public function get_users_list(Request $request)
    {
        $users = User::all();
        return response([
            'status' => 'success',
            'message' => 'Users List',
            'data' => $users
        ], 200);
    }
}
