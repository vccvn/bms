<?php
// controller
$c = 'Admin\\RouteController@';
// route name
$r = 'admin.route';
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
Route::post('options',                             $c.'getRouteOptions'                   )->name($r.'.option');