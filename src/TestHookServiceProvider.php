<?php

namespace TestHook;

use Illuminate\Events\Dispatcher;
use Illuminate\Support\ServiceProvider;

class TestHookServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Add routers
        app('router')->get('test', function () {
            return 'Hello world!';
        });

        // Add routes with Voyager's prefix (group)
        app(Dispatcher::class)->listen('voyager.admin.routing', function ($router) {
            $router->get('test', function () {
                return 'Hello possibly not-logged-in user!';
            });
        });

        // Add routes behind Voyager authentication
        app(Dispatcher::class)->listen('voyager.admin.routing', function ($router) {
            $router->get('test-with-login', function () {
                return 'Hello logged-in user!';
            })->name('test');
        });
    }
}
