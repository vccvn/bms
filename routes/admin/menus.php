<?php

// controller
$c = 'Admin\\MenuController@';
// route name
$r = 'admin.menu';
/*
|----------------------------------------------------------------------------------------------------------------------------
|                       URL                       |              CONTROLLER               |               NAME
|----------------------------------------------------------------------------------------------------------------------------
*/
Route::get('/',                                   $c.'list'                               )->name($r);
$r.='.';
Route::get('list.html',                           $c.'list'                               )->name($r.'list');
Route::get('add.html',                            $c.'form'                               )->name($r.'add');
Route::get('update/{id}.html',                    $c.'form'                               )->name($r.'update');
Route::post('save',                               $c.'save'                               )->name($r.'save');
Route::post('delete',                             $c.'delete'                             )->name($r.'delete');

$c = 'Admin\\MenuItemController@';
Route::get('detail/{menu_id}.html',               $c.'detail'                             )->name($r.'detail');
Route::get('menu/{menu_id}/add-item.html',        $c.'form'                               )->name($r.'item.add');
Route::get('menu/{menu_id}/update-item/{id?}',    $c.'Form'                               )->name($r.'item.update');
Route::post('/save-item',                         $c.'save'                               )->name($r.'item.save');
Route::post('/ajax-save-item',                    $c.'ajaxSave'                           )->name($r.'item.ajax-save');
Route::post('delete-item',                        $c.'delete'                             )->name($r.'item.delete');
Route::post('change-item-priority',               $c.'changePriority'                     )->name($r.'item.change-priority');
Route::post('sort-items',                         $c.'sortItems'                          )->name($r.'item.sort');
Route::get('edit-item-form',                      $c.'getForm'                            )->name($r.'item.form');