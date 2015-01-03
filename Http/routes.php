<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => LaravelLocalization::setLocale(), 'before' => 'LaravelLocalizationRedirectFilter|auth.admin|permissions'], function (Router $router) {
    $router->group(['prefix' => Config::get('core::core.admin-prefix') . '/user', 'namespace' => 'Modules\User\Http\Controllers'], function (Router $router) {
        $router->resource('users', 'Admin\UserController', ['except' => ['show'], 'names' => [
                'index' => 'admin.user.user.index',
                'create' => 'admin.user.user.create',
                'store' => 'admin.user.user.store',
                'edit' => 'admin.user.user.edit',
                'update' => 'admin.user.user.update',
                'destroy' => 'admin.user.user.destroy',
            ]]);
        $router->resource('roles', 'Admin\RolesController', ['except' => ['show'], 'names' => [
            'index' => 'admin.user.role.index',
            'create' => 'admin.user.role.create',
            'store' => 'admin.user.role.store',
            'edit' => 'admin.user.role.edit',
            'update' => 'admin.user.role.update',
            'destroy' => 'admin.user.role.destroy',
        ]]);
    });
});

$router->group(['prefix' => 'auth', 'namespace' => 'Modules\User\Http\Controllers'], function (Router $router) {
    # Login
    $router->get('login', ['before' => 'auth.guest', 'as' => 'login', 'uses' => 'AuthController@getLogin']);
    $router->post('login', array('as' => 'login.post', 'uses' => 'AuthController@postLogin'));
    # Register
    $router->get('register', ['before' => 'auth.guest', 'as' => 'register', 'uses' => 'AuthController@getRegister']);
    $router->post('register', array('as' => 'register.post', 'uses' => 'AuthController@postRegister'));
    # Account Activation
    $router->get('activate/{userId}/{activationCode}', 'AuthController@getActivate');
    # Reset password
    $router->get('reset', ['as' => 'reset', 'uses' => 'AuthController@getReset']);
    $router->post('reset', ['as' => 'reset.post', 'uses' => 'AuthController@postReset']);
    $router->get('reset/{id}/{code}', ['as' => 'reset.complete', 'uses' => 'AuthController@getResetComplete']);
    $router->post('reset/{id}/{code}', ['as' => 'reset.complete.post', 'uses' => 'AuthController@postResetComplete']);
    # Logout
    $router->get('logout', array('as' => 'logout', 'uses' => 'AuthController@getLogout'));
});
