<?php

return [
    'user.users' => [
        'index' => trans('user::users.list user'),
        'create' => trans('user::users.create user'),
        'edit' => trans('user::users.edit user'),
        'destroy' => trans('user::users.destroy user'),
    ],
    'user.roles' => [
        'index' => trans('user::roles.list resource'),
        'create' => trans('user::roles.create resource'),
        'edit' => trans('user::roles.edit resource'),
        'destroy' => trans('user::roles.destroy resource'),
    ],
    'account.api-keys' => [
        'index' => trans('user::users.list api key'),
        'create' => trans('user::users.create api key'),
        'destroy' => trans('user::users.destroy api key'),
    ],
];
