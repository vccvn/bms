<?php
// controller
$c = 'Admin\\ScheduleController@';
// route name
$r = 'admin.schedule';
/*
|----------------------------------------------------------------------------------------------------------------------------
|                       URL                       |              CONTROLLER               |               NAME
|----------------------------------------------------------------------------------------------------------------------------
*/    
Route::get('/',                                    $c.'schedules'                         )->name($r);
Route::get('list.html',                            $c.'list'                              )->name($r.'.list');
Route::get('add.html',                             $c.'form'                              )->name($r.'.add');
Route::post('save',                                $c.'save'                              )->name($r.'.save');
Route::post('create',                              $c.'create'                            )->name($r.'.create');
Route::post('delete',                              $c.'delete'                            )->name($r.'.delete');

Route::get(
    '/month/{year}/{/month}.html',
    $c.'schedules'
)->name($r.'.month')
->where('year','[0-9]{4}')
->where('month','[0-9]{1,2}');


Route::get(
    'detail/{year}/{month}/{license_plate}.html', 
    $c.'schedule'
)->name($r.'.detail')
->where('year','[0-9]{4}')
->where('month','[0-9]{1,2}');
