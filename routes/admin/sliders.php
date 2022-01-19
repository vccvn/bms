<?php
// controller
$c = 'Admin\\SliderController@';
// route name
$r = 'admin.slider';
/*
|----------------------------------------------------------------------------------------------------------------------------
|                       URL                       |              CONTROLLER               |               NAME
|----------------------------------------------------------------------------------------------------------------------------
*/    
Route::get('/',                                   $c.'list'                               )->name($r);
$r.='.';
Route::get('list.html',                           $c.'list'                               )->name($r.'list');
Route::get('detail/{id}.html',                    $c.'detail'                             )->name($r.'detail');
Route::get('add.html',                            $c.'form'                               )->name($r.'add');
Route::get('update/{id}.html',                    $c.'form'                               )->name($r.'update');
Route::post('save',                               $c.'save'                               )->name($r.'save');
Route::post('delete',                             $c.'delete'                             )->name($r.'delete');
Route::post('change-priority',                    $c.'changePriority'                     )->name($r.'change-priority');

Route::get('slider/{slider_id}/add-item.html',    $c.'itemForm'                           )->name($r.'item.add');
Route::get('slider/{slider_id}/update-item/{id?}',$c.'itemForm'                           )->name($r.'item.update');
Route::post('/save-item',                         $c.'saveItem'                           )->name($r.'item.save');
Route::post('delete-item',                        $c.'deleteItem'                         )->name($r.'item.delete');
Route::post('change-item-priority',               $c.'changeItemPriority'                 )->name($r.'item.change-priority');