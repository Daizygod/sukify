<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Lang;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    protected function redirectTo($request)
    {
//        if (!$request->expectsJson()) {
            response()->json([
                'error' => Lang::choice('auth.unauthorized', 1, [])
            ], 400);
//        } else {
//            route('login');
//        }
    }
}
