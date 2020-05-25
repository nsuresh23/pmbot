<?php

namespace App\Http\Middleware;

use Url;
use Session;
use Closure;
use Illuminate\Http\Response;

class CheckRole
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
    
    if($request->user() === null) {
      return new Response(view('layout.login'));
    }

    if (auth()->user() === null) {
      return new Response(view('layout.login'));
    }

    $actions = $request->route()->getAction();

    $roles = isset($actions['roles']) ? $actions['roles'] : null;

    if (is_array($roles)) {

      if(in_array($request->user()->role,$roles))

        return $next($request);

      else

        return new Response(view('errors.error401'));

    }
    else
    
      return $next($request);

    //return new Response(view('layout.404error'));
    //
  }
}
