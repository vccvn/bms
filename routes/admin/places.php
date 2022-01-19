<?php
// controller
$c = 'Admin\\PlaceController@';
// route name
$r = 'admin.place';
/*
|----------------------------------------------------------------------------------------------------------------------------
|                       URL                       |              CONTROLLER               |               NAME
|----------------------------------------------------------------------------------------------------------------------------
*/    
Route::get('/',                                    $c.'index'                             )->name($r);
Route::get('list.html',                            $c.'list'                              )->name($r.'.list');
Route::get('add.html',                             $c.'form'                              )->name($r.'.add');
Route::get('update/{id}.html',                     $c.'form'                              )->name($r.'.update');
Route::post('save',                                $c.'save'                              )->name($r.'.save');
Route::post('import',                              $c.'import'                            )->name($r.'.import');
Route::post('delete',                              $c.'delete'                            )->name($r.'.delete');

Route::post('options',                             $c.'getPlaceOptions'                   )->name($r.'.option');



$c = 'Admin\\PassingPlaceController@';
Route::get('journeys/{id}.html',                   $c.'showJourney'                       )->name($r.'.journey');

Route::post('add-passing-place',                   $c.'addPassingPlace'                   )->name($r.'.add-passing-place');

Route::post('delete-passing',                      $c.'delete'                            )->name($r.'.delete-passing');

Route::post('sort-places',                         $c.'sortPlaces'                        )->name($r.'.sort-place');
