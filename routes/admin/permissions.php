<?php

// controller
$c = 'Admin\\RoleController@';
// route name
$r = 'admin.permission';
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

$c = 'Admin\\PermissionController@';

Route::any('get-in-role/{id?}',                   $c.'getUseersInRole'                    )->name($r.'get-users-in-role');
Route::any('get-not-in-role/{id?}',               $c.'getUseersNotInRole'                 )->name($r.'get-users-not-in-role');
Route::post('add-users-role',                     $c.'addUsersRole'                       )->name($r.'add-users-role');
Route::post('remmove-users-role',                 $c.'removeUsersRole'                    )->name($r.'remove-users-role');

Route::any('get-required-role/{id?}',             $c.'getModulesRequiredRole'             )->name($r.'get-modules-required-role');
Route::any('get-not-required-role/{id?}',         $c.'getModulesNotRequiredRole'          )->name($r.'get-modules-not-required-role');
Route::post('add-modules-role',                   $c.'addModulesRole'                     )->name($r.'add-modules-role');
Route::post('remmove-modules-role',               $c.'removeModulesRole'                  )->name($r.'remove-modules-role');
