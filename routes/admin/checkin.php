<?php
// controller
$c = 'Admin\\CheckInController@';
// route name
$r = 'admin.checkin';
/*
|----------------------------------------------------------------------------------------------------------------------------
|                       URL                       |              CONTROLLER               |               NAME
|----------------------------------------------------------------------------------------------------------------------------
*/    
Route::get('/',                                    $c.'index'                             )->name($r);
Route::get('search',                               $c.'search'                            )->name($r.'.search');
Route::get('update/{id}.html',                     $c.'form'                              )->name($r.'.update');
Route::post('save',                                $c.'save'                              )->name($r.'.save');
Route::post('import',                              $c.'import'                            )->name($r.'.import');
Route::post('check',                               $c.'addLog'                            )->name($r.'.check');
Route::post('cancel',                              $c.'cancel'                            )->name($r.'.cancel');
Route::post('delete',                              $c.'delete'                            )->name($r.'.delete');

