<?php
// controller
$c = 'Admin\\TripController@';
// route name
$r = 'admin.trip';
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
Route::post('/change-status',                      $c.'changeStatus'                      )->name($r.'.status');
Route::post('/get-update-form',                    $c.'getUpdateForm'                     )->name($r.'.get-form');