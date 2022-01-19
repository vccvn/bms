<?php

$c = 'Admin\\DashboardController@';
// route name
$r = 'admin';

/*
|----------------------------------------------------------------------------------------------------------------------------
|                       URL                       |              CONTROLLER               |               NAME
|----------------------------------------------------------------------------------------------------------------------------
*/    

Route::get('/',                                   $c.'index'                              )->name($r.'.dashboard');



########################################### Modules ########################################

// các moduld sẽ được đưa vào 1 list
$groups = [
    'users', 'posts', 'pages', 'crawler', 'products', 'orders', 'comments',
    'contacts', 'modules', 'permissions', 'options', 'menus',
    'sliders', 'contents', 'dynamics', 'subcribers', 'provinces', 
    'stations','routes', 'places', 'companies', 'buses', 'schedules', 'trips',
    'logs', 'tickets'
];

foreach ($groups as $group) {
    Route::prefix($group)->group(base_path('routes/admin/'.$group.'.php'));
}

Route::middleware('cube')->group(base_path('routes/admin/free-style.php'));
