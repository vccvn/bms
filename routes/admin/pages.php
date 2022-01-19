<?php

// controller
$c = 'Admin\\PageController@';
// route name
$r = 'admin.page';
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
Route::post('check-slug',                          $c.'checkSlug'                         )->name($r.'.check-slug');
Route::post('get-slug',                            $c.'getSlug'                           )->name($r.'.get-slug');
Route::get('replace.html',                         $c.'replace'                           )->name($r.'.replace');