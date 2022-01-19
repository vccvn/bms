<?php

// controller
$c = 'Admin\\WebOptionController@';
// route name
$r = 'admin.option';
/*
|----------------------------------------------------------------------------------------------------------------------------
|                       URL                       |              CONTROLLER               |               NAME
|----------------------------------------------------------------------------------------------------------------------------
*/    
Route::get('/',                                   $c.'list'                               )->name($r);
Route::get('detail/{id}.html',                    $c.'detail'                             )->name($r.'.detail');
Route::post('add',                                $c.'add'                                )->name($r.'.add');
Route::post('save',                               $c.'save'                               )->name($r.'.save');
Route::post('delete',                             $c.'delete'                             )->name($r.'.delete');
Route::get('{group_option}.html',                 $c.'list'                               )->name($r.'.group');