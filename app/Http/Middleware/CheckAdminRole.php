<?php

namespace App\Http\Middleware;

use Url;
use Session;
use Closure;
use Illuminate\Http\Response;

class CheckAdminRole
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
      return new Response(view('auth.login'));
    }

    if (auth()->user() === null) {
      return new Response(view('auth.login'));
    }

    $actions = $request->route()->getAction();

    $middlewares = isset($actions['middleware']) ? $actions['middleware'] : null;
    if (is_array($middlewares)) {

      if(in_array($request->user()->empname, $middlewares))

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
