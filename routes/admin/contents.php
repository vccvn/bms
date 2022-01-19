<?php
// controller
$c = 'Admin\\TagController@';
// route name
$r = 'admin.content';
/*
|----------------------------------------------------------------------------------------------------------------------------
|                       URL                       |              CONTROLLER               |               NAME
|----------------------------------------------------------------------------------------------------------------------------
*/    
Route::get('/',                                   $c.'list'                               )->name($r);
$r.='.';
Route::get('tags.html',                           $c.'list'                               )->name($r.'tag');
Route::get('tags/data.json',                      $c.'getData'                            )->name($r.'tag.data');
Route::get('tags/tag.json',                       $c.'getTag'                             )->name($r.'tag.get');
Route::get('tags/add.html',                       $c.'form'                               )->name($r.'tag.add');
Route::post('tags/update',                        $c.'saveUpdate'                         )->name($r.'tag.update');
Route::post('tags/save',                          $c.'save'                               )->name($r.'tag.save');
Route::post('tags/delete',                        $c.'delete'                             )->name($r.'tag.delete');
Route::post('tags/ajax-add',                      $c.'add'                                )->name($r.'tag.ajax-add');
Route::get('tags/live-add.html',                  $c.'add'                                )->name($r.'tag.live-add');