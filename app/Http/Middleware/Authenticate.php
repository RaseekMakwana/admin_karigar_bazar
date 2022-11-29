<?php

namespace App\Http\Middleware;

use Closure;

class Authenticate
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function handle($request, Closure $next)
    {
        
        if($request->session()->get('login_status') == "1"){
            $response = $next($request);
            return $response->header('Cache-Control','nocache, no-store, max-age=0, must-revalidate')
                    ->header('Pragma','no-cache')
                    ->header('Expires','Sat, 26 Jul 1997 05:00:00 GMT');
        }else{
            
            return redirect("login");
        }
        return $next($request);
    }
}
