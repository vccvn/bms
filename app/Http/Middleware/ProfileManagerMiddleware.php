<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\View;

use App\Profile\Setting;
use App\Profile\Info;

class ProfileManagerMiddleware
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
        
        $profile = get_login_profile();
        if(!$profile || $profile->id != get_profile_id()){
            return redirect('/error/403');
        }
        $profile_menu = get_profile_menu();
        // menu

        View::share(compact('profile_menu'));


        return $next($request);
    }
}
