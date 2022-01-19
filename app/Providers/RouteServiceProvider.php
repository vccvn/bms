<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

use App\Repositories\Profiles\ProfileRepository;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapAccountRoutes();

        if(in_array(get_subdomain(), ['admin.bms', 'bns-admin'])){
            $this->mapAdminServerRoutes();

            $this->mapWeb2Routes();
        }
        else{
            $this->mapAdminRoutes();

            $this->mapWebRoutes();
        }
        

        //
    }

    /**
     * Define the "admin" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapAdminRoutes()
    {

        Route::prefix('admin')
             ->middleware(['web','auth','cube','admin.share'])
             ->namespace($this->namespace)
             ->group(base_path('routes/admin.php'));
    }


    /**
     * Define the "admin" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapAdminRServeroutes()
    {

        Route::middleware(['web','auth','cube','admin.share'])
             ->namespace($this->namespace)
             ->group(base_path('routes/admin.php'));
    }


    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {

        Route::middleware(['web','web.share','cube'])
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    
    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWeb2Routes()
    {

        Route::middleware(['web','web.share','cube'])
             ->namespace($this->namespace)
             ->group(base_path('routes/web2.php'));
    }

    
    /**
     * Define the "profile" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapAccountRoutes()
    {
        Route::prefix('account')
             ->middleware(['web','auth','cube','web.share'])
             ->namespace($this->namespace)
             ->group(base_path('routes/account.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
}
