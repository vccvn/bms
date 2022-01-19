<?php
// controller
$c = 'Admin\\SubcriberController@';
// route name
$r = 'admin.subcriber';
/*
|----------------------------------------------------------------------------------------------------------------------------
|                       URL                       |              CONTROLLER               |               NAME
|----------------------------------------------------------------------------------------------------------------------------
*/    
Route::get('/',                                    $c.'index'                             )->name($r);
Route::get('list.html',                            $c.'list'                              )->name($r.'.list');
Route::post('delete',                              $c.'delete'                            )->name($r.'.delete');