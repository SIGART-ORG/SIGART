<?php

namespace App\Http\Middleware;

use Closure;
use App\Access;

class Permits
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $page)
    {
        $permit = Access::permits($page);

        if($permit){
            return $next($request);
        }

        return redirect('main')->with('error','You have not admin access');
    }
}
