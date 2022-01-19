<?php
// controller
$c = 'Admin\\OrderController@';
// route name
$r = 'admin.order';
/*
|----------------------------------------------------------------------------------------------------------------------------
|                       URL                       |              CONTROLLER               |               NAME
|----------------------------------------------------------------------------------------------------------------------------
*/    
Route::get('/',                                    $c.'list'                              )->name($r);
Route::get('/list.html',                           $c.'list'                              )->name($r.'.list');
Route::get('/list/{slug}.html',                    $c.'listStatus'                        )->name($r.'.list-status');
Route::get('/order.json',                          $c.'getOrderData'                      )->name($r.'.view');
Route::post('/change-status',                      $c.'changeStatus'                      )->name($r.'.change-status');
Route::get('/help.html',                           $c.'listHelp'                          )->name($r.'.help');
Route::get('/detail/{id}.html',                    $c.'detail'                            )->name($r.'.detail');

Route::post('/delete',                             $c.'delete'                            )->name($r.'.delete');