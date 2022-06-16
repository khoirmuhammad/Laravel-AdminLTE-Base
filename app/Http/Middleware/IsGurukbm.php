<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsGurukbm
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(session('role') == env('ROLE_GURU_KBM')){
            return $next($request);
        }
   
        return redirect('/')->with('error',"Anda tidak punya hak akses untuk halaman tersebut");
    }
}
