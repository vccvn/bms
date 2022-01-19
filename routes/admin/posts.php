<?php
// controller
$c = 'Admin\\PostController@';
// route name
$r = 'admin.post';
/*
|----------------------------------------------------------------------------------------------------------------------------
|                       URL                       |              CONTROLLER               |               NAME
|----------------------------------------------------------------------------------------------------------------------------
*/    
Route::get('/',                                    $c.'index'                             )->name($r);
Route::get('list.html',                            $c.'list'                              )->name($r.'.list');
Route::get('detail/{id}.html',                     $c.'detail'                            )->name($r.'.detail');
Route::get('add.html',                             $c.'form'                              )->name($r.'.add');
Route::get('update/{id}.html',                     $c.'form'                              )->name($r.'.update');
Route::post('save',                                $c.'save'                              )->name($r.'.save');
Route::post('delete',                              $c.'delete'                            )->name($r.'.delete');
Route::get('product-links-data.json',              $c.'getProductData'                    )->name($r.'.product-links-data');
Route::post('check-slug',                          $c.'checkSlug'                         )->name($r.'.check-slug');
Route::post('get-slug',                            $c.'getSlug'                           )->name($r.'.get-slug');
Route::get('replace.html',                         $c.'replace'                           )->name($r.'.replace');


######################################## CATEGORY ########################################

Route::prefix('categories')->group(function(){
    // controller
    $c = 'Admin\\PostCategoryController@';
    // route name
    $r = 'admin.post.category';
    /*
    |----------------------------------------------------------------------------------------------------------------------------
    |                       URL                       |              CONTROLLER               |               NAME
    |----------------------------------------------------------------------------------------------------------------------------
    */    
    Route::get('/',                                    $c.'index'                             )->name($r);
    Route::get('list.html',                            $c.'list'                              )->name($r.'.list');
    Route::get('add.html',                             $c.'form'                              )->name($r.'.add');
    Route::get('update/{id}.html',                     $c.'form'                              )->name($r.'.update');
    Route::post('save',                                $c.'save'                              )->name($r.'.save');
    Route::post('delete',                              $c.'delete'                            )->name($r.'.delete');
});