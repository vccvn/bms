<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\View;

use App\Profile\Setting;
use App\Profile\Info;

class ProfileSharingMiddleware
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
        

        $webSetting = new Setting;
        $siteinfo = new Info;
        View::share(compact('webSetting','siteinfo'));


        return $next($request);
    }
}
