<?php

// controller
$c = 'Admin\\TicketController@';
// route name
$r = 'admin.ticket';
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


Route::prefix('pricing')->group(function(){
    // controller
    $c = 'Admin\\TicketPriceController@';
    // route name
    $r = 'admin.ticket.price';
    /*
    |----------------------------------------------------------------------------------------------------------------------------
    |                       URL                       |              CONTROLLER               |               NAME
    |----------------------------------------------------------------------------------------------------------------------------
    */    
    Route::get('/',                                    $c.'index'                             )->name($r);
    Route::get('list.html',                            $c.'list'                              )->name($r.'.list');
    Route::get('test.html',                            $c.'test'                              )->name($r.'.test');
    Route::get('detail/{id}.html',                     $c.'detail'                            )->name($r.'.detail');
    Route::get('add.html',                             $c.'form'                              )->name($r.'.add');
    Route::get('update/{id}.html',                     $c.'form'                              )->name($r.'.update');
    Route::post('save',                                $c.'save'                              )->name($r.'.save');
    Route::post('delete',                              $c.'delete'                            )->name($r.'.delete');
});

