<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class CheckSessionExpiration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if($this->isSessionExpired())
        {
            Auth::logout();
            Session::flush();
            return redirect()->route('login');
        }
        return $next($request);
    }

    private function isSessionExpired()
    {
        $expiryTimestamp = Session::get('expiry_timestamp');
        return $expiryTimestamp && now()->timestamp > $expiryTimestamp;
    }
}
