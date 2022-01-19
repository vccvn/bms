<?php

/*
|--------------------------------------------------------------------------
| Profile Routes
|--------------------------------------------------------------------------
*/

// controller
$c = 'User\\ProfileController@';
// route name
$r = 'user.profile';
/*
|----------------------------------------------------------------------------------------------------------------------------
|                     URL                     |           CONTROLLER            |               NAME
|----------------------------------------------------------------------------------------------------------------------------
*/    
Route::get('/',                                $c.'index'                       )->name($r);

Route::get('info',                             $c.'index'                       )->name($r.'.info');


######################################## Cong tac vien ########################################

Route::prefix('settings')->group(function(){
    // controller
    $c = 'User\\ProfileController@';
    // route name
    $r = 'user.profile.setting';
    /*
    |----------------------------------------------------------------------------------------------------------------------------
    |                     URL                     |           CONTROLLER            |               NAME
    |----------------------------------------------------------------------------------------------------------------------------
    */    
    Route::get('/',                                $c.'index'                       )->name($r);
    
    $c = 'User\\SettingController@';
    
    Route::get('general',                          $c.'general'                     )->name($r.'.general');
    Route::post('save-general',                    $c.'saveGeneral'                 )->name($r.'.save-general');
    
    Route::get('avatar',                           $c.'avatar'                      )->name($r.'.avatar');
    Route::post('save-avatar',                     $c.'saveAvatar'                  )->name($r.'.save-avatar');
    
    Route::get('account',                          $c.'account'                     )->name($r.'.account');
    Route::post('save-account',                    $c.'saveAccount'                 )->name($r.'.save-account');
    
    Route::get('password',                         $c.'password'                    )->name($r.'.password');
    Route::post('save-password',                   $c.'savePassword'                )->name($r.'.save-password');
    
    
    
});

######################################## END CTV ########################################
