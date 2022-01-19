<?php
// controller
$c = 'Admin\\StationController@';
// route name
$r = 'admin.station';
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
Route::post('import',                              $c.'import'                            )->name($r.'.import');
Route::post('delete',                              $c.'delete'                            )->name($r.'.delete');

Route::post('options',                             $c.'getStationOptions'                 )->name($r.'.option');
Route::post('end-options',                         $c.'getEndOptions'                     )->name($r.'.end-option');

