<?php namespace Modules\User\Providers;

use Illuminate\Bus\Dispatcher;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * @var array
     */
    protected $providers = [
        'Sentinel' => 'Cartalyst\\Sentinel\\Laravel\\SentinelServiceProvider',
        'Sentry'   => 'Cartalyst\\Sentry\\SentryServiceProvider',
    ];

    /**
     * @var array
     */
    protected $middleware = [
        'User' => [
            'auth.guest' => 'GuestMiddleware',
        ],
    ];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->booted(function ($app) {
            $this->registerMiddleware($app['router']);
            $this->registerBindings();
        });
    }

    /**
     * @param Dispatcher $dispatcher
     */
    public function boot(Dispatcher $dispatcher)
    {
        if ($this->asgardIsInstalled() === true) {
            $this->app->register(
                $this->getUserPackageServiceProvider()
            );
        }

        $dispatcher->mapUsing(function ($command) {
            return Dispatcher::simpleMapping(
                $command, 'Modules\User\Commands', 'Modules\User\Commands\Handlers'
            );
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

    private function registerBindings()
    {
        $driver = config('asgard.user.users.driver', 'Sentry');

        $this->app->bind(
            'Modules\User\Repositories\UserRepository',
            "Modules\\User\\Repositories\\{$driver}\\{$driver}UserRepository"
        );
        $this->app->bind(
            'Modules\User\Repositories\RoleRepository',
            "Modules\\User\\Repositories\\{$driver}\\{$driver}RoleRepository"
        );
        $this->app->bind(
            'Modules\Core\Contracts\Authentication',
            "Modules\\User\\Repositories\\{$driver}\\{$driver}Authentication"
        );
    }

    private function registerMiddleware($router)
    {
        foreach ($this->middleware as $module => $middlewares) {
            foreach ($middlewares as $name => $middleware) {
                $class = "Modules\\{$module}\\Http\\Middleware\\{$middleware}";

                $router->middleware($name, $class);
            }
        }
    }

    private function getUserPackageServiceProvider()
    {
        $driver = config('asgard.user.users.driver', 'Sentry');

        if (!isset($this->providers[$driver])) {
            throw new \Exception("Driver [{$driver}] does not exist");
        }

        return $this->providers[$driver];
    }

    /**
     * Check if Asgard is installed
     * @return bool
     */
    private function asgardIsInstalled()
    {
        /** @var \Illuminate\Contracts\Filesystem\Filesystem $finder */
        $finder = app('Illuminate\Contracts\Filesystem\Filesystem');

        return $finder->exists('.env');
    }
}
