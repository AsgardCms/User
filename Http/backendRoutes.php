<?php

$router->group(['prefix' => '/user'], function () {
    get('users', ['as' => 'admin.user.user.index', 'uses' => 'UserController@index']);
    get('users/create', ['as' => 'admin.user.user.create', 'uses' => 'UserController@create']);
    post('users', ['as' => 'admin.user.user.store', 'uses' => 'UserController@store']);
    get('users/{users}/edit', ['as' => 'admin.user.user.edit', 'uses' => 'UserController@edit']);
    put('users/{users}/edit', ['as' => 'admin.user.user.update', 'uses' => 'UserController@update']);
    delete('users/{users}', ['as' => 'admin.user.user.destroy', 'uses' => 'UserController@destroy']);

    get('roles', ['as' => 'admin.user.role.index', 'uses' => 'RolesController@index']);
    get('roles/create', ['as' => 'admin.user.role.create', 'uses' => 'RolesController@create']);
    post('roles', ['as' => 'admin.user.role.store', 'uses' => 'RolesController@store']);
    get('roles/{roles}/edit', ['as' => 'admin.user.role.edit', 'uses' => 'RolesController@edit']);
    put('roles/{roles}/edit', ['as' => 'admin.user.role.update', 'uses' => 'RolesController@update']);
    delete('roles/{roles}', ['as' => 'admin.user.role.destroy', 'uses' => 'RolesController@destroy']);
});
