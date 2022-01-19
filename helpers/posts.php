<?php
use App\Repositories\Pages\PageRepository;

use App\Repositories\Dynamic\DynamicRepository;
use App\Repositories\Dynamic\CategoryRepository as DynamicCategoryRepository;

use App\Repositories\Products\ProductRepository;
use App\Repositories\Products\ProductCategoryRepository;

use App\Repositories\Posts\PostRepository;
use App\Repositories\Posts\CategoryRepository as PostCategoryRepository;

use App\Repositories\Categories\BaseCategoryRepository;


use App\Repositories\Posts\BasePostRepository as CustomPostRepository;

use App\Repositories\Tags\TagRepository;







if (!function_exists('get_category_list')) {
    function get_category_list($type='post',$args = [])
    {
        $a = array_merge(['status'=>200], (array) $args);
        if($type == 'product') return (new ProductCategoryRepository())->get($a);
        return (new PostCategoryRepository())->get($a);
    }
}


if (!function_exists('get_pupular_category_list')) {
    function get_pupular_category_list($type='post',$args = [])
    {
        $a = array_merge(['status'=>200], (array) $args);
        if($type == 'product')return (new ProductCategoryRepository())->get($a);
        return (new PostCategoryRepository())->get($a);
    }
}


if (!function_exists('get_post_list')) {
    function get_post_list($args = [])
    {
        $a = array_merge(['status'=>200], (array) $args);
        return (new PostRepository())->getActiveList($a);
    }
}



if (!function_exists('get_dynamic_list')) {
    function get_dynamic_list($dynamic, $args = [])
    {
        $a = array_merge(['status'=>200], (array) $args);
        return (new DynamicRepository())->getActiveDynamics($dynamic, $a);
    }
}


if (!function_exists('get_dynamics')) {
    function get_dynamics($dynamic, $args = [])
    {
        $a = array_merge(['status'=>200], (array) $args);
        return (new DynamicRepository())->getActiveDynamics($dynamic, $a);
    }
}


if (!function_exists('get_custom_posts')) {
    function get_custom_posts($args = [])
    {
        $a = array_merge(['status'=>200], (array) $args);
        return (new CustomPostRepository())->getActiveList($a);
    }
}

if (!function_exists('get_post_args_parse')) {
    function get_post_args_parse($args = [])
    {
        $a = array_merge(['status'=>200], (array) $args);

        if(!isset($a['type'])) $a['type'] = 'post';
        elseif(in_array(strtolower($a['type']), ['all','*'])){
            unset($a['type']);
        }
        if(!isset($a['status'])) $a['status'] = 200;
        elseif(in_array(strtolower($a['status']), ['all','*'])){
            unset($a['status']);
        }
        
        return $a;
    }
}

if (!function_exists('get_posts')) {
    function get_posts($args = [])
    {
        $a = get_post_args_parse($args);
        
        return (new CustomPostRepository())->getList($a);
    }
}


if (!function_exists('get_post')) {
    function get_post($args = [])
    {
        $a = get_post_args_parse($args);
        
        return (new CustomPostRepository())->first($a);
    }
}





if (!function_exists('get_product_list')) {
    function get_product_list($args = [])
    {
        $a = array_merge(['status'=>200], (array) $args);
        return (new ProductRepository())->get($a);
    }
}



if (!function_exists('get_product_args_parse')) {
    function get_product_args_parse($args = [])
    {
        $a = array_merge(['status'=>200], (array) $args);
        if(!isset($a['status'])) $a['status'] = 200;
        elseif(in_array(strtolower($a['status']), ['all','*'])){
            unset($a['status']);
        }
        
        return $a;
    }
}

if (!function_exists('get_products')) {
    function get_products($args = [])
    {
        $a = get_product_args_parse($args);
        
        return (new ProductRepository())->get($a);
    }
}


if (!function_exists('get_product')) {
    function get_product($args = [])
    {
        $a = get_product_args_parse($args);
        
        return (new ProductRepository())->first($a);
    }
}


if(!function_exists('get_tag_list')){
    function get_tag_list($args = [])
    {
        $args = (array) $args;
        return (new TagRepository())->get($args);
    }
}

if(!function_exists('get_popular_tags')){
    function get_popular_tags($args = [])
    {
        $args = (array) $args;
        return (new TagRepository())->getPopularTags($args);
    }
}


// use App\Repositories\Dynamic\DynamicRepository;
// use App\Repositories\Dynamic\CategoryRepository as DynamicCategoryRepository;

if(!function_exists('get_dynamic_category_options')){
    function get_dynamic_category_options($id = 0, $args = [])
    {
        $rep = new DynamicCategoryRepository();
        if($id && $dynamic = get_post(['type'=>'dynamic','parent_id'=>0])){
            $rep->setType($dynamic->slug);
        }else{
            $rep->setType('post');
        }
        return $rep->getCategoryOptions();
    }
}


if(!function_exists('get_categories')){
    function get_categories($args = [])
    {
        $rep = new BaseCategoryRepository();
        return $rep->get(get_post_args_parse($args));
    }
}

if(!function_exists('get_category')){
    function get_category($args = [])
    {
        $rep = new BaseCategoryRepository();
        return $rep->first(get_post_args_parse($args));
    }
}



