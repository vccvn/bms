<?php

// controller
$c = 'Admin\\CommentController@';
// route name
$r = 'admin.comment';
/*
|----------------------------------------------------------------------------------------------------------------------------
|                       URL                       |              CONTROLLER               |               NAME
|----------------------------------------------------------------------------------------------------------------------------
*/    
Route::get('/other.html',                          $c.'lisother'                          )->name($r.'.other');
Route::get('/posts.html',                          $c.'listOnPost'                        )->name($r.'.post');
Route::get('/products.html',                       $c.'listOnProduct'                     )->name($r.'.product');
Route::get('/pages.html',                          $c.'listOnPage'                        )->name($r.'.page');
Route::get('/dynamic.html',                        $c.'listOnDynamic'                     )->name($r.'.dynamic');
Route::get('/help.html',                           $c.'listHelp'                          )->name($r.'.help');
Route::get('/detail/{id}.html',                    $c.'detail'                            )->name($r.'.detail');

Route::post('/delete',                             $c.'delete'                            )->name($r.'.delete');
Route::post('/approve',                            $c.'approve'                           )->name($r.'.approve');
Route::post('/unapprove',                          $c.'unapprove'                         )->name($r.'.unapprove');