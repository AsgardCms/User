<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' => '/user'], function (Router $router) {
    $router->get('users', ['as' => 'admin.user.user.index', 'uses' => 'UserController@index']);
    $router->get('users/create', ['as' => 'admin.user.user.create', 'uses' => 'UserController@create']);
    $router->post('users', ['as' => 'admin.user.user.store', 'uses' => 'UserController@store']);
    $router->get('users/{users}/edit', ['as' => 'admin.user.user.edit', 'uses' => 'UserController@edit']);
    $router->put('users/{users}/edit', ['as' => 'admin.user.user.update', 'uses' => 'UserController@update']);
    $router->get('users/{users}/sendResetPassword', ['as' => 'admin.user.user.sendResetPassword', 'uses' => 'UserController@sendResetPassword']);
    $router->delete('users/{users}', ['as' => 'admin.user.user.destroy', 'uses' => 'UserController@destroy']);

    $router->get('roles', ['as' => 'admin.user.role.index', 'uses' => 'RolesController@index']);
    $router->get('roles/create', ['as' => 'admin.user.role.create', 'uses' => 'RolesController@create']);
    $router->post('roles', ['as' => 'admin.user.role.store', 'uses' => 'RolesController@store']);
    $router->get('roles/{roles}/edit', ['as' => 'admin.user.role.edit', 'uses' => 'RolesController@edit']);
    $router->put('roles/{roles}/edit', ['as' => 'admin.user.role.update', 'uses' => 'RolesController@update']);
    $router->delete('roles/{roles}', ['as' => 'admin.user.role.destroy', 'uses' => 'RolesController@destroy']);
});
