<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



use Illuminate\Support\Facades\Auth;
######################################## CATEGORY ########################################

// controller
$c = 'Client\\HomeController@';
$t = 'Client\\TestController@';
// route name
$r = 'client.';
/*
|----------------------------------------------------------------------------------------------------------------------------
|                       URL                       |              CONTROLLER               |               NAME
|----------------------------------------------------------------------------------------------------------------------------
*/    
Route::get('/',                                    $c.'index'                             )->name('home');
Route::get('/tra-cuu.html',                        'Client\\TripController@search'        )->name('client.trip.search');


Route::get('/trips.json',                          'Client\\TripController@ajaxSearch'        )->name('client.trip.ajax-search');
Route::get('/trip-detail.json',                    'Client\\TripController@detail'        )->name('client.trip.detail');

Route::get('sitemap.xml',                         'SitemapController@index'               )->name('sitemap.xml');


$ac = 'Client\\AuthController@';
$auth = 'AuthController@';
/*
|----------------------------------------------------------------------------------------------------------------------------
|                       URL                       |              CONTROLLER               |               NAME
|----------------------------------------------------------------------------------------------------------------------------
*/    
Route::get('dang-nhap.html',                        $ac.'login'                           )->name('client.auth.login');
Route::post('dang-nhap.html',                       $ac.'postLogin');

Route::get('dang-ky.html',                          $ac.'register'                        )->name('client.auth.register');
Route::post('dang-ky.html',                         $ac.'postRegister');

Route::get('quen-mat-khau.html',                    $ac.'forgot'                          )->name('client.auth.forgot');
Route::post('quen-mat-khau.html',                   $ac.'postForgot');

Route::get('dat-lai-mat-khau/{token}',              $ac.'resetPasswordViaMailToken'       )->name('client.user.password.reset');
Route::post('luu-mat-khau',                         $ac.'savePasswordViaMailToken'        )->name('client.user.password.reset.save');

Route::post('check-auth',                           $auth.'checkAuth'                    )->name('client.auth.check');

Route::get('dang-xuat.html',                        $auth.'logout'                        )->name('client.auth.logout');









$ac = 'Admin\\AuthController@';
/*
|----------------------------------------------------------------------------------------------------------------------------
|                       URL                       |              CONTROLLER               |               NAME
|----------------------------------------------------------------------------------------------------------------------------
*/    
Route::get('login',                                 $ac.'login'                           )->name('login');
Route::post('login',                                $ac.'postLogin');

Route::get('register',                              $ac.'register'                        )->name('register');
Route::post('register',                             $ac.'postRegister');

Route::get('forgot',                                $ac.'forgot'                          )->name('forgot');
Route::post('forgot',                               $ac.'postForgot');

Route::get('reset-password/{token}',                $ac.'resetPasswordViaMailToken'       )->name('user.password.reset');
Route::post('save-new-password',                    $ac.'savePasswordViaMailToken'        )->name('user.password.reset.save');

Route::get('logout'        ,                        $auth.'logout'                        )->name('logout');


Route::get('error/{error}',function($error=null){
    if(!in_array($error,['403','404'])) $error = 404;
	return view('admin.errors.'.$error);
});



// controller
$c = 'Client\\HomeController@';
// route name
$r = 'client.';
$n = $r;
/*
|----------------------------------------------------------------------------------------------------------------------------
|                       URL                       |              CONTROLLER               |               NAME
|----------------------------------------------------------------------------------------------------------------------------
*/    
$cc = 'Client\\CommentController@';
Route::get('/tim-kiem',                            'Client\\SearchController@search'      )->name($r.'search');
Route::post('/gui-phan-hoi',                       $cc.'save'                             )->name($r.'comment.save');
Route::post('/nhan-ho-tro',                        $cc.'addHelpComment'                   )->name($r.'help.save-help');
Route::post('/gui-binh-luan',                      $cc.'ajaxSave'                         )->name($r.'comment.ajax-save');


$c = 'Client\\ContactController@';
Route::get('/lien-he.html',                        $c.'index'                            )->name($r.'contact');
Route::post('gui-lien-he',                         $c.'send'                             )->name($r.'contact.send');
Route::post('gui-lien-he-bang-ajax',               $c.'ajaxSend'                         )->name($r.'contact.ajax-send');


Route::post('subcribe',                            'Client\\SubcriberController@ajaxSend')->name($r.'subcriber.ajax-send');


/*
|----------------------------------------------------------------------------------------------------------------------------
|                       URL                       |              CONTROLLER               |               NAME
|----------------------------------------------------------------------------------------------------------------------------
*/    


############################ Tin tuc ############################

$c = 'Client\\PostController@';
$n = 'client.post';
/*
|----------------------------------------------------------------------------------------------------------------------------
|                       URL                       |              CONTROLLER               |               NAME
|----------------------------------------------------------------------------------------------------------------------------
*/
Route::get('/tin-bai.html',                                    $c.'index'                             )->name($n);
$n.='.';

Route::get('/tin-bai-moi-cap-nhat.html',                   $c.'index'                             )->name($n.'news');
Route::get('/tin-noi-bat.html',                    $c.'popular'                           )->name($n.'popular');
Route::get('/danh-muc-bai-viet/{slug}.html',                  $c.'viewCate'                          )->name($n.'category.view');
Route::get('/danh-muc-bai-viet/{slug}/{child_slug}.html',     $c.'viewCate'                          )->name($n.'category.view-child');
Route::get('/tin-bai/{slug}.html',                         $c.'detail'                            )->name($n.'view');


############################ End Tin tuc ############################



######################################## thong bao ########################################

Route::prefix('thong-bao')->group(function(){
    // controller
    $c = 'Client\\AlertController@';
    // route name
    $r = 'client.alert';
    /*
    |----------------------------------------------------------------------------------------------------------------------------
    |                       URL                       |              CONTROLLER               |               NAME
    |----------------------------------------------------------------------------------------------------------------------------
    */    
    Route::get('/',                                   $c.'index'                              )->name($r);
    Route::get('loi.html',                            $c.'error'                              )->name($r.'.add');
    Route::get('chuc-mung.html',                      $c.'message'                            )->name($r.'.message');
    
    
});








##################### VUI LONG KHONG DAT THEM ROUTE SAU ROUTE NAY ###########################

$c = 'Client\\DynamicController@';
$n = 'client.dynamic.';
/*
|----------------------------------------------------------------------------------------------------------------------------
|                       URL                       |              CONTROLLER               |               NAME
|----------------------------------------------------------------------------------------------------------------------------
*/

Route::get('/danh-muc-{dynamic_slug}/{lug}.html',  $c.'viewCate'                           )->name($n.'category.view');
Route::get('/danh-muc-{dynamic_slug}/{slug}/{child_cate_slug}.html',$c.'viewCate'          )->name($n.'category.view-child');
Route::get('/{slug}.html',                         $c.'viewPage'                           )->name($n.'view');
Route::get('/{parent_slug}/{child_slug}.html',     $c.'viewChild'                          )->name($n.'view-child');
