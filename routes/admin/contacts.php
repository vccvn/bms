<?php

// controller
$c = 'Admin\\ContactController@';
// route name
$r = 'admin.contact';
/*
|----------------------------------------------------------------------------------------------------------------------------
|                       URL                       |              CONTROLLER               |               NAME
|----------------------------------------------------------------------------------------------------------------------------
*/    
Route::get('/',                                    $c.'index'                             )->name($r);
Route::get('list.html',                            $c.'list'                              )->name($r.'.list');
Route::get('detail/{id}.html',                     $c.'detail'                            )->name($r.'.detail');
Route::post('delete',                              $c.'delete'                            )->name($r.'.delete');
Route::post('send-reply',                          $c.'sendReply'                         )->name($r.'.send-reply');