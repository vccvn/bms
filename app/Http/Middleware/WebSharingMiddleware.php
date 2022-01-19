<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\View;

use App\Web\Option;
use App\Web\Setting;
use App\Web\Siteinfo;
use App\Web\Embed;
use App\Repositories\Menus\MenuRepository;
use App\Shop\ShoppingCart;
use App\Shop\Wishlist;

class WebSharingMiddleware
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
        if(!($data = cache('web_share_data'))){
            // menu
            $mrp = new MenuRepository();
            $main_menu = null;
            if($menu = $mrp->first(['active'=>1,'@order_by'=>['priority'=>'DESC']])){
                if($m = $menu->toMenuList()){
                    $main_menu = $m;
                }
            }
        
            // websetting
            $__setting = new Setting;

            $siteinfo = new Siteinfo;

            $__embed = new Embed;

            $data = compact('__setting','siteinfo', '__embed','main_menu');

            $cache = [
                'web_share_data' => $data
            ];
            $time = $__setting->cache_data_time;
            $t = (is_numeric($time) && $time>0)?$time:0;
            cache($cache, $t);


        }
        
        View::share($data);


        return $next($request);
    }
}
