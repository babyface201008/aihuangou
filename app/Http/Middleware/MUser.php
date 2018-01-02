<?php

namespace App\Http\Middleware;

use Closure;
use App\Tools;

class MUser
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
     if ( $request->session()->has('mcy_user_id') )
     {
      return $next($request);
    }else{
      return redirect('/admin');
    }
  }
}
