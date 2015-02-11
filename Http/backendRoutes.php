<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/user'], function (Router $router) {
    $router->resource('users', 'UserController', ['except' => ['show'], 'names' => [
            'index' => 'admin.user.user.index',
            'create' => 'admin.user.user.create',
            'store' => 'admin.user.user.store',
            'edit' => 'admin.user.user.edit',
            'update' => 'admin.user.user.update',
            'destroy' => 'admin.user.user.destroy',
        ]]);
    $router->resource('roles', 'RolesController', ['except' => ['show'], 'names' => [
        'index' => 'admin.user.role.index',
        'create' => 'admin.user.role.create',
        'store' => 'admin.user.role.store',
        'edit' => 'admin.user.role.edit',
        'update' => 'admin.user.role.update',
        'destroy' => 'admin.user.role.destroy',
    ]]);
});

