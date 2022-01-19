<?php

use App\Repositories\Pages\PageRepository;
use App\Repositories\Dynamic\DynamicRepository;
use App\Repositories\Products\ProductRepository;
use App\Repositories\Posts\PostRepository;
use App\Repositories\Products\ProductCategoryRepository;
use App\Repositories\Categories\CategoryRepository;
use App\Repositories\Sliders\SliderRepository;
use App\Repositories\Tags\TagRepository;
use App\Repositories\Users\UserRepository;
use App\Repositories\Menus\MenuRepository;
use App\Shop\ShoppingCart;
use Cube\Files;
use Cube\Html\Menu as HtmlMenu;

/**
 * lay gia tri setting
 */
if (!function_exists('getSetting')) {
    /**
     * phuong thuc lay ve thiet lap
     * @param string $property
     * @return mixed
     */
    function getSetting($property = null)
    {
        static $settings = null;
        if (!$settings) {
            $settings = new App\Web\Setting;
        }
        if (!is_null($property)) {
            if (is_string($property) && isset($settings->{$property})) {
                return $settings->{$property};
            }
            return null;
        }
        return $settings;
    }
}
if(!function_exists('get_station_id')){
    function get_station_id()
    {
        return getSetting('station_id');
    }
    
}


/**
 * lay gia tri site info (thong tin website)
 */
if (!function_exists('siteinfo')) {
    /**
     * phuong thuc lay ve thiet lap
     * @param string $property
     * @return mixed
     */
    function siteinfo($property = null)
    {
        static $settings = null;
        if (!$settings) {
            $settings = new App\WebOptions\Siteinfo;
        }
        if (!is_null($property)) {
            if (is_string($property) && isset($settings->{$property})) {
                return $settings->{$property};
            }
            return null;
        }
        return $settings;
    }
}

/**
 * set active menu
 */

if (!function_exists('setMenuKey')) {

    /**
     * thiet lap menu active key
     * @param string
     */
    function setMenuKey($key = null, $value = null)
    {
        HtmlMenu::addActiveKey($key, $value);
    }

}

/**
 * giai ma va lua anh duoi dang base64
 */

if (!function_exists('save_public_file')) {
    /**
     * @param string $content
     * @param string $filename
     * @param string $path
     */
    function save_public_file($content, $filename, $path='')
    {
        $files = new Cube\Files();
        $files->setDir(public_path($path?$path:'/contents'));
        
        if ($files->save_contents($content, $filename)) {
            return true;
        }
        return false;
    }
}

/**
 * giai ma va lua anh duoi dang base64
 */

if (!function_exists('save_base64_image')) {
    /**
     * @param string $base64_image_string
     * @param string $output_file_without_extension
     * @param string $path_with_end_slash
     */
    function save_base64_image($base64_image_string, $output_file_without_extension, $path_with_end_slash = "")
    {
        $splited = explode(',', substr($base64_image_string, 5), 2);
        if (count($splited) == 1) {
            return null;
        }

        $mime = $splited[0];
        $data = $splited[1];
        $mime_split_without_base64 = explode(';', $mime, 2);
        $mime_split = explode('/', $mime_split_without_base64[0], 2);
        if (count($mime_split) == 2) {
            $extension = $mime_split[1];
            if ($extension == 'jpeg') {
                $extension = 'jpg';
            }

            $output_file_with_extension = $output_file_without_extension . '.' . $extension;
        }
        $files = new Cube\Files();
        $files->setDir(public_path('/'));
        $filename = ($path_with_end_slash) ? (rtrim($path_with_end_slash, '/') . '/' . ltrim($output_file_with_extension, '/')) : $output_file_with_extension;
        if ($files->save_contents(base64_decode($data), $filename)) {
            return $output_file_with_extension;
        }
        return null;
    }
}

if(!function_exists('get_video_data')){
    /**
     * lây thong tin video từ url.
     * hỗ trợ youtube là chính =)))
     * @param string $url
     * 
     * @return App\Light\Any trả về object any
     */
    function get_video_data($url=null){
        if(!$url) return null;
        $a = array();
        if(preg_match_all('/.*youtu\.be\/(.*?)($|\?|#)/si',$url,$m)){
            $a['id'] = $m[1][0];
            $a['server'] = 'youtube';
            $a['thumbnail'] = 'http://img.youtube.com/vi/'.$a['id'].'/hqdefault.jpg';
            $a['embed_url'] = "http://www.youtube.com/embed/$a[id]?rel=0&wmode=opaque";
        }
        elseif(preg_match_all('/youtube\.com\/watch\?.*v=(.*?)($|&|#)/si',$url,$m)){
            $a['id'] = $m[1][0];
            $a['server'] = 'youtube';
            $a['thumbnail'] = 'http://img.youtube.com/vi/'.$a['id'].'/hqdefault.jpg';
            $a['embed_url'] = "http://www.youtube.com/embed/$a[id]?rel=0&wmode=opaque";
        }
        
        elseif(preg_match_all('/\.*vimeo.com\/(.*?)($|\?)/si',$url,$m)){
            $v = explode('/',$m[1][0]);
            $a['id'] = $v[count($v)-1];
            $a['server'] = 'vimeo';
            $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/".$a['id'].".php"));
            $a['thumbnail'] = $hash[0]['thumbnail_large'];
            $a['embed_url'] = "http://player.vimeo.com/video/$a[id]?wmode=opaque";
        }
        elseif(preg_match_all('/.*facebook.com\/(.*?)\/videos\/(.*?)\//si',$url,$m)){
            $a['id'] = $m[2][0];
            $a['page_id'] = $m[1][0];
            $a['server'] = 'facebook';
            $a['thumbnail'] = null;
            $ac = urlencode(get_home_url());
            $a['embed_url'] = "https://www.facebook.com/v2.0/plugins/video.php?allowfullscreen=true&container_width=620&href=$ac%2F$a[page_id]%2Fvideos%2Fvb.$a[page_id]%2F$a[id]%2F%3Ftype%3D3&locale=en_US&sdk=joey";
        }
        if(!$a) return null;
        $obj = new \App\Light\Any($a);
        return $obj;
    }
}

if (!function_exists('vn_to_str')) {
    /**
     * [bỏ dấu tiếng việt của 1 chuỗi]
     * @param string $str
     * @author QuanNV   - Create    - 2018-01-18
     * @return string
     */
    function vn_to_str($str)
    {
        $unicode = array(
            'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
            'd' => 'đ',
            'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'i' => 'í|ì|ỉ|ĩ|ị',
            'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
            'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'D' => 'Đ',
            'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
            'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
        );
        foreach ($unicode as $nonUnicode => $uni) {
            $str = preg_replace("/($uni)/i", $nonUnicode, $str);
        }
        return $str;
    }
}



if(!file_exists('vn_to_en')){
    /**
     * chuen toan bo chuoi tieng viet thanh chu in thuong
     * @param string $str
     */
    function vn_to_en($str){
        $file = new Files();
        $file->cd('json/language');
        $data = $file->getJSON('str');
        return str_replace($data->vi, $data->en, $str);
    }
}
if(!file_exists('vn_to_lower')){
    /**
     * chuen toan bo chuoi tieng viet thanh chu in thuong
     * @param string $str
     */
    function vn_to_lower($str){
        $file = new Files();
        $file->cd('json/language');
        $data = $file->getJSON('str');
        return str_replace($data->upper, $data->lower, $str);
    }
}
if(!file_exists('vn_to_upper')){
    /**
     * chuyen toan bo chuoi co dau tieng viet thanh in hoa
     * @param string $str
     */
    function vn_to_upper($str){
        $file = new Files();
        $file->cd('json/language');
        $data = $file->getJSON('str');
        return str_replace($data->lower, $data->upper, $str);
    }
}


if (!function_exists('isDate')) {
    function isDate($value)
    {
        if (!$value) {
            return false;
        }

        try {
            new \DateTime($value);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

}


if (!function_exists('is_date')) {
    function is_date($day=0, $month=0, $year=0)
    {
        if (!$day || !$month || !$year || !is_numeric($day) || !is_numeric($month) || !is_numeric($year)) {
            return false;
        }
        if($day > 30) {
            if(in_array($month,[1,3,5.7,8,10,12])) return true;
            return false;
        }elseif($day > 29){
            if($month!=2) return true;
            return false;
        }elseif($day == 29){
            if($year%100==0){
                $year = $year/100;
            }
            if($year%4==0) return true;
            return false;
        }
        return true;
        
    }

}

if(!function_exists('get_time_seconds')){
    function get_time_seconds($time = null){
        $xs = [1, 60, 3600];
        $time = $time?$time:date('G:i:s');
        $times = explode(':', $time);
        $timeSeconds = 0;
        $c = count($times);
        if($c <= 3){
            $n = 0;
            for($i=$c-1; $i >= 0; $i--){
                $nb = (int) $times[$i];
                $timeSeconds+=$nb*$xs[$n];
                $n++;
            }
        }
        return $timeSeconds;
    }

}




if (!function_exists('to_number')) {
    /**
     * chuan so
     * @param string $value
     */
    function to_number($value)
    {
        if (is_numeric($value)) {
            $number = (((Int) $value) == $value) ? ((Int) $value) : ((float) $value);
            return $number;
        }
        return 0;
    }
}



if (!function_exists('parse_query_string')) {

    function parse_query_string($query = null, $data = null)
    {
        $arr = [];
        if (is_string($query)) {
            try {
                parse_str($query, $d);
                if ($d) {
                    $arr = $d;
                }
            } catch (exception $e) {
                // eo can lam gi cung dc
            }
        }
        if (is_array($data)) {
            foreach ($data as $name => $value) {
                if (!is_null($value) && (is_numeric($value) || is_string($value)) && strlen($value) > 0 && $name !='page') {
                    $arr[$name] = $value;
                }
            }
        }
        $s = '';
        if ($arr) {
            foreach ($arr as $n => $v) {
                $s .= "$n=$v&";
            }
            $s = trim($s, '&');
        }
        return $s;
    }

}

if (!function_exists('object_to_array')) {
    function object_to_array($d)
    {
        if (is_object($d)) {
            $d = get_object_vars($d);
        }

        if (is_array($d)) {
            return array_map(__FUNCTION__, $d);
        } else {
            return $d;
        }
    }
}


if (!function_exists('string_to_array')) {
    function string_to_array($s)
    {
        
    }
}
if (!function_exists('get_year_options')) {
    function get_year_options($s)
    {
        
    }
}



if (!function_exists('str_eval')) {
    /**
     * dien chu vao doan
     * @param string $text
     * @param array $data
     * @param int $char_type
     * @param string $char_start
     */
    function str_eval($text = null, $data = null, $char_type = 0, $char_start = '$')
    {
        $type = array(
            0 => array('start' => '{', 'end' => '}'),
            1 => array('start' => '[', 'end' => ']'),
            2 => array('start' => '(', 'end' => ')'),
            3 => array('start' => '/*', 'end' => '*/'),
            5 => array('start' => '<', 'end' => '>'),
        );
        $chars = array('$', '@', '%', '', '*', 'sd:');
        if (!is_string($text) && !is_array($data)) {
            return $text;
        }

        $start = '{';
        $end = '}';
        $char = '$';
        if (isset($type[$char_type])) {
            $ty = $type[$char_type];
            $start = $ty['start'];
            $end = $ty['end'];
        } elseif (is_string($char_type)) {
            $start = $char_type;
            if (strlen($char_type) > 1) {
                $end = '';
                $n = strlen($char_type) - 1;
                for ($i = $n; $i >= 0; $i--) {
                    $end .= substr($char_type, $i, 1);
                }
            } else {
                $end = $start;
            }
        }
        if (in_array($char_start, $chars)) {
            $char = $char_start;
        } elseif ($char_start && isset($chars[$char_start])) {
            $char = $chars[$char_start];
        } elseif ($char_start) {
            $char = $char_start;
        }
        $find = array();
        $replace = array();
        $find2 = array();
        $replace2 = array();

        foreach ($data as $name => $val) {
            if (is_array($val)) {
                continue;
            }

            $find[] = $start . $char . $name . $end;
            $replace[] = $val;

        }

        $txt = str_replace($find, $replace, $text);
        $txt = preg_replace('/\{\$[A-z0-9_]\}/i', '', $txt);

        return $txt;
    }
}

// lay menu admin
if (!function_exists('get_active_module_list')) {
    function get_active_module_list()
    {
        $m = env('APP_ACTIVE_MODULE', '*');
        $k = strtolower($m);
        if(!in_array($k, ['*','all', ''])){
            return explode(',', str_replace(' ', '', $m));
        }
        return [];
    }
}



// lay menu admin
if (!function_exists('get_admin_menu')) {
    function get_admin_menu($type='default')
    {
        $user = Auth::user();
        if($user->isAdmin()){
            $type = 'admin';
        }elseif($user->hasRole('mod')){
            $type = 'mod';
        }elseif($user->hasRole('content')){
            $type = 'content';
        }elseif($user->hasRole('barie')){
            $type = 'barie';
        }else{
            $type = 'test';
        }
        

        $menu = [];
        $files = new Files();
        $files->cd('json/menus');
        if ($data = $files->getJSON('admin/'.$type.'.json')) {
            $menu = object_to_array($data);
        }
        if($m = get_active_module_list()){
            $mn = [];
            foreach($menu as $item){
                if(isset($item['active_key'])){
                    if(in_array($item['active_key'], $m)){
                        $mn[] = $item;
                    }
                }
            }
            $menu = $mn;
        }
        $last = array_pop($menu);

        if(in_array($type,['admin','mod','content'])){
            // them dynamic vào menu
            $pr = new DynamicRepository();
            if (count($list = $pr->get(['parent_id' => 0, 'status'=>200]))) {
                foreach ($list as $page) {
                    $menu[] = \App\Models\Menu::parseAdminPageItem($page);
                }
            }
        }
        
        $menu[] = $last;
        $admin_menu = [
            'type' => 'list',
            'data' => $menu,
        ];
        return $admin_menu;
    }
}
if (!function_exists('get_client_menu')) {
    function get_client_menu($args = []){
        // menu
        $mrp = new MenuRepository();
        $menu = [];
        if($mn = $mrp->first($args)){
            if($m = $mn->toMenuList()){
                $menu = $m;
            }
        }
        return $menu;
    }
}



if (!function_exists('get_slider')) {
    function get_slider($pos = 100, $args = [])
    {
        return (new SliderRepository())->getSlider($pos, $args);
    }
}

if(!function_exists('get_user_list')){
    function get_user_list($args = [])
    {
        $args = (array) $args;
        return (new UserRepository())->get($args);
    }
}

if(!function_exists('is_json')){

    function is_json($string){
        return is_string($string) && is_array(json_decode($string, true)) ? true : false;
    }
}





if(!function_exists('get_theme')){

    function get_theme(){
        static $theme = null;
        if(!$theme){
            $theme = env('APP_THEME','corpro');
        }
        return $theme;
    }
}

if(!function_exists('theme_url')){

    function theme_url($path = null){
        static $theme = null;
        if(!$theme){
            $theme = get_theme();
        }
        $u = asset('themes/clients/'.$theme);
        if($path){
            $u.= '/'.ltrim($path,'/');
        }
        return $u;
    }
}

if(!function_exists('get_theme_url')){

    function get_theme_url($path = null){
        return theme_url($path);
    }
}




if(!function_exists('theme_path')){

    function theme_path($path = null){
        static $theme = null;
        if(!$theme){
            $theme = env('APP_THEME','corpro');
        }
        $u = 'clients.'.$theme;
        if($path){
            $u.= '.'.ltrim($path,'.');
        }
        return $u;
    }
}

if(!function_exists('get_theme_path')){

    function get_theme_path($path = null){
        return theme_path($path);
    }
}



if(!function_exists('component_path')){

    function component_path($component = null){
        $p = theme_path('_components');
        if($component){
            $p.= '.'.ltrim($component,'.');
        }
        return $p;
    }
}

if(!function_exists('template_path')){

    function template_path($template = null){
        $p = theme_path('_templates');
        if($template){
            $p.= '.'.ltrim($template,'.');
        }
        return $p;
    }
}

if(!function_exists('theme_asset')){

    function theme_asset($path = null){
        $u = theme_url('assets');
        if($path){
            $u.= '/'.ltrim($path,'/');
        }
        return $u;
    }
}

if(!function_exists('get_theme_asset')){

    function get_theme_asset($path = null){
        return theme_asset($path);
    }
}
if(!function_exists('get_time_array')){
    function get_time_array($time)
    {
        $m = 60;
        $h = 3600;
        $d = 3600*24;
        $dd = $time % $d;
        $day = ($time - $dd) / $d;
        $dh = $dd % $h;
        $hour = ($dd - $dh) / $h;
        $dm = $dh % $m;
        $minute = ($dh - $dm) / $m;
        $second = $dm;
        return compact('day', 'hour', 'minute', 'second');
    }
}

if(!function_exists('get_datetime_array')){
    function get_datetime_array($datetime)
    {
        $array = ['year' => null, 'month' => null,'day' => null, 'hour' => null, 'minute' => null, 'second' => null];
        if(count($datetimes = explode(' ', $datetime))==2){
            $date = explode('-', $datetimes[0]);
            $array['year'] = $date[0];
            $array['month'] = $date[1];
            $array['day'] = $date[2];

            $time = explode(':', $datetimes[1]);
            $array['hour'] = $time[0];
            $array['minute'] = $time[1];
            $array['second'] = $time[2];
        }
        return $array;
    }
}



if(!function_exists('get_calendar_table'))
{

    /**
     * lay du luieu bang ngay thang
     */
    function get_calendar_table($month=null,$year=null) 
    {

        if(!$year) $year = date('Y');
        if(!$month) $month = date('m');
        // Create array containing abbreviations of days of week.
        $daysOfWeek = array('M','T','W','T','F','S','S');
        $dow = array('mon','tue','wed','thu','fri','sat','sun');
    
        // What is the first day of the month in question?
        $firstDayOfMonth = mktime(0,0,0,$month,1,$year);
    
        // How many days does this month contain?
        $numberDays = date('t',$firstDayOfMonth);
    
        // Retrieve some information about the first day of the
        // month in question.
        $dateComponents = getdate($firstDayOfMonth);
    
        // What is the name of the month in question?
        $monthName = $dateComponents['month'];
    
        // What is the index value (0-6) of the first day of the
        // month in question.
        $dayOfWeek = $dateComponents['wday'] - 1;

        if($dayOfWeek<0) $dayOfWeek = 6;
    
        // Create the table tag opener and day headers
        $dateTable = [];

        // Create the calendar headers
    
    
        // Create the rest of the calendar
    
        // Initiate the day counter, starting with the 1st.
    
        $currentDay = 1;
    
        // The variable $dayOfWeek is used to
        // ensure that the calendar
        // display consists of exactly 7 columns.
    
        if ($dayOfWeek > 0) { 
             for($k = 0; $k < $dayOfWeek; $k++){
                $dateTable[0][] = [
                    'type' => 'day_before',
                    'day' => null,
                    'rday' => null,
                    'date' => null,
                    'wday' => null,
                    'time' => null
                ];
            }
            
        }
        
        $month = str_pad($month, 2, "0", STR_PAD_LEFT);
        $i = 0;
        while ($currentDay <= $numberDays) {
    
             // Seventh column (Saturday) reached. Start a new row.
    
             if ($dayOfWeek == 7) {
    
                  $dayOfWeek = 0;
                  $i++;
    
             }
             
             $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
             
             $date = "$year-$month-$currentDayRel";
    
    
             // Increment counters
             $dateTable[$i][] = [
                'type' => 'day',
                'day' => $currentDay,
                'rday' => $currentDayRel,
                'date' => $date,
                'wday' => $dow[$dayOfWeek],
                'time' => strtotime($date.' 00:00:00')
            ];
             $currentDay++;
             $dayOfWeek++;
             
        }
        
        
    
        // Complete the row of the last week in month, if necessary
    
        if ($dayOfWeek != 7) { 
        
            $remainingDays = 7 - $dayOfWeek;
             for($k = 0; $k < $remainingDays; $k++){
                $dateTable[$i][] = [
                    'type' => 'day_before',
                    'day' => null,
                    'rday' => null,
                    'date' => null,
                    'wday' => null,
                    'time' => null
                ];
            }
    
        }
        
    
        return $dateTable;
    
    }
    
}