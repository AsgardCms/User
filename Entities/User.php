<?php namespace Modules\User\Entities;

use Cartalyst\Sentinel\Users\EloquentUser as SentinelUser;
use Laracasts\Presenter\PresentableTrait;

class User extends SentinelUser
{
    use PresentableTrait;

    protected $fillable = [
        'email',
        'password',
        'permissions',
        'first_name',
        'last_name'
    ];

    protected $presenter = 'Modules\User\Presenters\UserPresenter';
}
