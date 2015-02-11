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

    protected $middleware = [
        'User' => [
            'auth.guest' => 'GuestMiddleware'
        ]
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
        $dispatcher->mapUsing(function($command)
        {
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
		$this->app->bind(
			'Modules\User\Repositories\UserRepository',
			'Modules\User\Repositories\Sentinel\SentinelUserRepository'
		);
		$this->app->bind(
			'Modules\User\Repositories\RoleRepository',
			'Modules\User\Repositories\Sentinel\SentinelRoleRepository'
		);
        $this->app->bind(
            'Modules\Core\Contracts\Authentication',
            'Modules\User\Repositories\Sentinel\SentinelAuthentication'
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
}
