<?php

 // controller
 $c = 'Admin\\UserController@';
 // route name
 $r = 'admin.user';
 /*
 |----------------------------------------------------------------------------------------------------------------------------
 |                       URL                       |              CONTROLLER               |               NAME
 |----------------------------------------------------------------------------------------------------------------------------
 */    
 Route::get('/',                                    $c.'index'                             )->name($r);
 Route::get('list.html',                            $c.'list'                              )->name($r.'.list');
 Route::get('detail/{id}.html',                     $c.'detail'                            )->name($r.'.detail');
 Route::get('add.html',                             $c.'form'                              )->name($r.'.add');
 Route::get('update/{id}.html',                     $c.'form'                              )->name($r.'.update');
 Route::post('save',                                $c.'save'                              )->name($r.'.save');
 Route::post('delete',                              $c.'delete'                            )->name($r.'.delete');
 Route::get('link/data.json',                       $c.'getData'                           )->name($r.'.link.data');
 Route::get('link/user.json',                       $c.'getUser'                           )->name($r.'.link.get');