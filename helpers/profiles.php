<?php

use Cube\Files;

use App\Repositories\Profiles\ProfileRepository;
use App\Repositories\Profiles\Tags\TagLinkRepository;

if(!function_exists('get_server_name')){
    /**
     * get subdomain
     */
    function get_server_name(){
        $server_name = Request::server("SERVER_NAME");
        return $server_name;
    }
}
if(!function_exists('get_domain')){
    /**
     * get domain
     */
    function get_domain(){
        $domain = env('APP_DOMAIN','chinhlatoi.vn');
        return $domain;
    }
}
if(!function_exists('get_subdomain')){
    /**
     * get subdomain
     */
    function get_subdomain(){
        $domain = env('APP_DOMAIN','chinhlatoi.vn');
        $server_name = Request::server("SERVER_NAME");
        if(count($dms = explode($domain, $server_name))>=1){
            return trim($dms[0],'.');
        }
        return null;
    }
}

// lay menu profile
if (!function_exists('get_profile_menu')) {
    function get_profile_menu()
    {
        $menu = [];
        $files = new Files();
        $files->cd('json/menus');
        if ($data = $files->getJSON('profile-manager.json')) {
            $menu = object_to_array($data);
        }
        // them dynamic vào menu
        // $pr = new PageRepository();
        // if (count($list = $pr->get(['type' => 'dynamic', 'parent_id' => 0]))) {
        //     foreach ($list as $page) {
        //         $menu[] = \App\Models\Menu::parseAdminPageItem($page);
        //     }
        // }

        $admin_menu = [
            'type' => 'list',
            'data' => $menu,
        ];
        return $admin_menu;
    }
}


if(!function_exists('get_select_day_options')){
    function get_select_day_options($label='Ngày')
    {
        $data = [$label];
        for($i = 1; $i < 32; $i++){
            $d = ($i<=9?'0':'').$i;
            $data[$d] = $d;
        }
        return $data;
        
    }
}
if(!function_exists('get_select_month_options')){

    function get_select_month_options($label='Tháng')
    {
        $data = [$label];
        for($i = 1; $i < 13; $i++){
            $d = ($i<=9?'0':'').$i;
            $data[$d] = $d;
        }
        return $data;
    }
}

if(!function_exists('get_select_year_options')){
    function get_select_year_options($from=null, $to=null, $label='Năm')
    {
        $data = [$label];
        if(!$from) $from = date('Y');
        if(!$to) $to = date('Y')-50;
        if($from < $to){
            for($i = $from; $i <= $to; $i++){
                $d = ($i<=9?'0':'').$i;
                $data[$d] = $d;
            }
        }else{
            for($i = $from; $i >= $to; $i--){
                $d = ($i<=9?'0':'').$i;
                $data[$d] = $d;
            }
        }
        return $data;
    }
}

if(!function_exists('get_login_profile')){
    function get_login_profile()
    {
        if($user = auth()->user()){
            $id = $user->id;
            $pr = new ProfileRepository();

            return $pr->findBy('user_id', $id);
        }
        return null;
    }
}

if(!function_exists('get_profile_id')){
    function get_profile_id()
    {
        $id = ProfileRepository::getActiveID();
        return $id;
    }
}

if(!function_exists('is_date')){
    /**
     * Ham kiem tra ngay thang co hop le hay khong
     * @param day : Ngay
     * @param month : Thang
     * @param year : Nam
     * tra ve true neu dung du kien ngay thang va false neu sai
     */
    function is_date($day, $month, $year){
        $stt = true;
        switch($day){
            case 31:
                if($month==2||$month==4||$month==6||$month==9||$month==11) $stt = false;
            break;
            case 30:
                if($month == 2) $stt = false;
            break;
            case 29:
                if(($year % 4 != 0 || ($year%4==0&&$year%100==0))||$year % 4 == 0 && $year%100!=0){
                    $stt = false;
                }
            break;
            
        }
        return $stt;
    }

}

if(!function_exists('get_profile_tag_list')){
    function get_profile_tag_list($args = [])
    {
        $rep = new TagRepository();
        $rep->addDefaultParam('profile_id', get_profile_id());
        $args = (array) $args;
        return $rep->get($args);
    }
}
