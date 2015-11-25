<?php namespace Modules\User\Providers;

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
        'Usher'    => 'Maatwebsite\\Usher\\UsherServiceProvider'
    ];

    /**
     * @var array
     */
    protected $middleware = [
        'User' => [
            'auth.guest' => 'GuestMiddleware',
            'logged.in' => 'LoggedInMiddleware'
        ],
    ];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(
            $this->getUserPackageServiceProvider()
        );

        $this->registerBindings();
    }

    /**
     */
    public function boot()
    {
        $this->registerMiddleware($this->app['router']);

        $this->publishes([
            __DIR__ . '/../Resources/views' => base_path('resources/views/asgard/user'),
        ]);
        $this->loadViewsFrom(base_path('resources/views/asgard/user'), 'user');
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'user');
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
        $driver = config('asgard.user.users.driver', 'Sentinel');

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
        $driver = config('asgard.user.users.driver', 'Sentinel');

        if (!isset($this->providers[$driver])) {
            throw new \Exception("Driver [{$driver}] does not exist");
        }

        return $this->providers[$driver];
    }
}
