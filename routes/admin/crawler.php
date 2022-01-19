<?php

/*
|----------------------------------------------------------------------------------------------------------------------------
|                       URL                       |              CONTROLLER               |               NAME
|----------------------------------------------------------------------------------------------------------------------------
*/    
// controller
$c = 'Admin\\CrawlFrameController@';
// route name
$r = 'admin.crawler';
Route::get('/',                                    $c.'index'                             )->name($r);

$r1 = $r.'.frame';

Route::get('frames/list.html',                     $c.'list'                              )->name($r1.'.list');
Route::get('frames/add.html',                      $c.'form'                              )->name($r1.'.add');
Route::get('frames/{id}.html',                     $c.'form'                              )->name($r1.'.update');
Route::post('frames/save',                         $c.'save'                              )->name($r1.'.save');
Route::post('frames/delete',                       $c.'delete'                            )->name($r1.'.delete');

$c = 'Admin\\CrawlPostController@';
$r2 = $r.'.post';

Route::get('posts/crawl.html',                     $c.'form'                              )->name($r2.'.crawl');
Route::post('posts/save',                          $c.'save'                              )->name($r2.'.save');


$c = 'Admin\\CrawlTaskController@';
$r3 = $r.'.task';

Route::get('tasks.html',                           $c.'index'                             )->name($r3);
Route::get('tasks/list.html',                      $c.'index'                             )->name($r3.'.list');
Route::get('tasks/add.html',                       $c.'form'                              )->name($r3.'.add');
Route::get('tasks/{id}.html',                      $c.'form'                              )->name($r3.'.update');
Route::post('tasks/save',                          $c.'save'                              )->name($r3.'.save');
Route::post('tasks/delete',                        $c.'delete'                            )->name($r3.'.delete');
Route::post('tasks/run',                           $c.'run'                               )->name($r3.'.run');
Route::post('tasks/status',                        $c.'changeStatus'                      )->name($r3.'.status');


$c = 'Admin\\DynamicCategoryController@';
$r4 = $r.'.cate';
Route::get('categories',                           $c.'getCategories'                      )->name($r4);