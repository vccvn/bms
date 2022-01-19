<?php
// controller
$c = 'Admin\\BusController@';
// route name
$r = 'admin.bus';
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


Route::post('freq-trip-options',                   $c.'getFreqTripOptions'                )->name($r.'.trip-option');
Route::get('/schedule',                            $c.'schedule'                          )->name($r.'.schedule');


