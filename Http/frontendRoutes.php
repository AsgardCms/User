<?php

$router->group(['prefix' => 'auth'], function () {
    # Login
    get('login', ['middleware' => 'auth.guest', 'as' => 'login', 'uses' => 'AuthController@getLogin']);
    post('login', ['as' => 'login.post', 'uses' => 'AuthController@postLogin']);
    # Register
    if (config('asgard.user.users.allow_user_registration', true)) {
        get('register', ['middleware' => 'auth.guest', 'as' => 'register', 'uses' => 'AuthController@getRegister']);
        post('register', ['as' => 'register.post', 'uses' => 'AuthController@postRegister']);
    }
    # Account Activation
    get('activate/{userId}/{activationCode}', 'AuthController@getActivate');
    # Reset password
    get('reset', ['as' => 'reset', 'uses' => 'AuthController@getReset']);
    post('reset', ['as' => 'reset.post', 'uses' => 'AuthController@postReset']);
    get('reset/{id}/{code}', ['as' => 'reset.complete', 'uses' => 'AuthController@getResetComplete']);
    post('reset/{id}/{code}', ['as' => 'reset.complete.post', 'uses' => 'AuthController@postResetComplete']);
    # Logout
    get('logout', ['as' => 'logout', 'uses' => 'AuthController@getLogout']);
});
