<?php

$r = 'admin.dynamic';


$c = 'Admin\\DynamicCategoryController@';
$r.='.category';


Route::get('/{dynamic_slug}/categories.html',      $c.'getList'                           )->name($r);
$r.='.';
Route::get('/{dynamic_slug}/categories/list.html', $c.'getList'                           )->name($r.'list');
Route::get('/{dynamic_slug}/categories/add.html',  $c.'form'                              )->name($r.'add');
Route::get('/{dynamic_slug}/categories/{id}.html', $c.'form'                              )->name($r.'update');
Route::post('/{dynamic_slug}/categories/save',     $c.'save'                              )->name($r.'save');
Route::post('/{dynamic_slug}/categories/delete',   $c.'delete'                            )->name($r.'delete');


$c = 'Admin\\DynamicItemController@';

$t = 'admin.dynamic.item.';

Route::get('/{slug}.html',                         $c.'list'                              )->name('admin.dynamic.item');
Route::get('/{slug}/list.html',                    $c.'list'                              )->name($t.'list');
Route::get('/{slug}/add.html',                     $c.'form'                              )->name($t.'add');
Route::get('/{slug}/update/{id}.html',             $c.'form'                              )->name($t.'update');
Route::post('/{slug}/save',                        $c.'save'                              )->name($t.'save');
Route::post('/{slug}/delete',                      $c.'delete'                            )->name($t.'delete');