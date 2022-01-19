<?php

// controller
$c = 'Admin\\ModuleController@';
// route name
$r = 'admin.module';
/*
|----------------------------------------------------------------------------------------------------------------------------
|                       URL                       |              CONTROLLER               |               NAME
|----------------------------------------------------------------------------------------------------------------------------
*/    
Route::get('/',                                   $c.'list'                               )->name($r);
Route::get('list.html',                           $c.'list'                               )->name($r.'.list');
Route::get('detail/{id}.html',                    $c.'detail'                             )->name($r.'.detail');
Route::get('add.html',                            $c.'form'                               )->name($r.'.add');
Route::get('update/{id}.html',                    $c.'form'                               )->name($r.'.update');
Route::post('save',                               $c.'save'                               )->name($r.'.save');
Route::post('delete',                             $c.'delete'                             )->name($r.'.delete');