<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\View;

use App\Web\Setting;
use App\Web\Siteinfo;

class AdminSharingMiddleware
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
        $admin_menu = get_admin_menu(env('APP_WEB_TYPE','default'));
        // menu


        $webSetting = new Setting;
        $siteinfo = new Siteinfo;
        View::share(compact('admin_menu','webSetting','siteinfo'));


        return $next($request);
    }
}
