<?php

namespace App\Http\Middleware;

use Closure;

use Cube\Laravel\LaravelRoute;


use App\Models\Module;

class CubeMiddleware
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
        // return $next($request);

        //trich xuat thong tin can thiet cua route 
        $routeinfo = LaravelRoute::getRouteInfo($request->route());

        $queryBuilder = Module::where(function($query) use ($routeinfo){
            $query->where('type','route_uri')
                  ->where('route',$routeinfo['uri']);
        });
        
        // neu route co name thi them dieu kien hoac route
        if($routeinfo['name']){
            $queryBuilder->orwhere(function($query) use ($routeinfo){
                $query->where('type','route_name')
                      ->where('route',$routeinfo['name']);
            });
            
        }

        // hoac prefix 
        if($routeinfo['prefix']){
            $queryBuilder->orwhere(function($query) use ($routeinfo){
                $query->where('type','route_prefix')
                      ->where('route',$routeinfo['prefix']);
            });
        }
        // tim thong tin route trong db
        if($modules = $queryBuilder->get()){
            // chua dang nhap
            
            $list_id = [];
            $module_roles = [];
            foreach($modules as $module){
                if($roles = $module->getRoles()){
                    foreach($roles as $r){
                        if(!in_array($r->id,$list_id)){
                            $module_roles[] = $r;
                            $list_id[] = $r->id;
                        }
                    }
                }
            }
            
            
            
            // neu co role id thi kiem tra role id cua user
            if($module_roles){
                if (!($user = $request->user())) {
                    return redirect(route('login'));
                }
                // cho nay hoi roi nao
                $user_role_id_list = $user->getRoleIDList();

                $user_roles = $user->getRoles();

                if(!$user_role_id_list){
                    // neu rou co yeu cau quyen ma user ko co thi sai luon
                    // redirect ve trang nao do
                    return redirect('/error/403');
                }
                foreach($user_roles as $r){
                    // lam gi do neu can
                    // vi du: id == 1 là quyền admin tối cao
                    if(strtolower($r->name) == 'admin'){
                        return $next($request);
                    }
                }
                
                //neu can kiem tra quyen dac biet thi  duyet o day
            
                // cac quyen binh thong 
                // duyet mang role id cua route va kiem tra xem trong user co hay khong
                foreach($module_roles as $role){
                    if(!in_array($role->id,$user_role_id_list)){
                        // neu khong co trong role id vua user thi la sai
                        // redirect ve trang nao do
                        return redirect('/error/403');
                    }
                    // neu role dinh kem mot phuong thuc thi kiem tra phuong thuc do
                    if($role->handle){
                        // neu la ham hoac phuong thuc cua class nao do thi goi toi ham hay phuong thuc do
                        if(is_callable($role->handle)){
                            // goi ham voi 2 tham so la $request va $next tuong tu middleware
                            $handle = $role->handle;
                            $stt = $handle($request,$next);

                            // neu khong co gi dac biet thi handle chi nen tra ve boolean
                            if(!$stt){
                                // neu tra ve false
                                // redirect ve trang nao do
                                return redirect('/error/403');
                            }elseif($stt!==true){
                                // neu tra ve khong phai tru thi lam gi do o day
                                // tam thoi coi no la middleware nao do nen return lai luon
                                
                                # code here

                                return $stt;
                            }
                        }
                    }
                }
            }
        }
        return $next($request);
    }
}
