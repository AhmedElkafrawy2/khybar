<?php

namespace App\Http\Middleware;

use Closure;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ( auth()->guard('admin')->user()->id !== 1 )
        {
            session()->flash('fail', 'غير مسموح لك الوصول الى هذا الرابط.');
            return redirect()->route('dashboard');
        }
        return $next($request);
    }
}
