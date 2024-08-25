<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SingleDeviceLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        $existingSession = DB::table('user_sessions')
            ->where('user_id', $user->id)
            ->first();

        if ($existingSession && $existingSession->session_id !== $request->sessionId) {
            return response([
                'message' => 'Logout Successful',
                'status' => 'success'
            ], 200);
        } else {
        }

        return $next($request);
    }
}
