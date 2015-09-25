<?php namespace Modules\User\Repositories\Usher;

use Illuminate\Contracts\Auth\Guard;
use Modules\Core\Contracts\Authentication;
use Modules\User\Repositories\UserRepository;

class UsherAuthentication implements Authentication
{
    /**
     * @var Guard
     */
    private $guard;

    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * @param Guard          $guard
     * @param UserRepository $repository
     */
    public function __construct(Guard $guard, UserRepository $repository)
    {
        $this->guard = $guard;
        $this->repository = $repository;
    }

    /**
     * Authenticate a user
     * @param  array $credentials
     * @param  bool  $remember Remember the user
     * @return mixed
     */
    public function login(array $credentials, $remember = false)
    {
        return $this->guard->attempt($credentials, $remember);
    }

    /**
     * Register a new user.
     * @param  array $user
     * @return bool
     */
    public function register(array $user)
    {
        return $this->repository->create((array) $user);
    }

    /**
     * Assign a role to the given user.
     * @param  \Modules\User\Repositories\UserRepository $user
     * @param  \Modules\User\Repositories\RoleRepository $role
     * @return mixed
     */
    public function assignRole($user, $role)
    {
        return $user->assignRole($role);
    }

    /**
     * Log the user out of the application.
     * @return bool
     */
    public function logout()
    {
        return $this->guard->logout();
    }

    /**
     * Activate the given used id
     * @param  int    $userId
     * @param  string $code
     * @return mixed
     */
    public function activate($userId, $code)
    {
        // TODO
    }

    /**
     * Create an activation code for the given user
     * @param  \Modules\User\Repositories\UserRepository $user
     * @return mixed
     */
    public function createActivation($user)
    {
        // TODO
    }

    /**
     * Create a reminders code for the given user
     * @param  \Modules\User\Repositories\UserRepository $user
     * @return mixed
     */
    public function createReminderCode($user)
    {
        // TODO
    }

    /**
     * Completes the reset password process
     * @param         $user
     * @param  string $code
     * @param  string $password
     * @return bool
     */
    public function completeResetPassword($user, $code, $password)
    {
        // TODO
    }

    /**
     * Determines if the current user has access to given permission
     * @param $permission
     * @return bool
     */
    public function hasAccess($permission)
    {
        return $this->guard->user()->hasAccess($permission);
    }

    /**
     * Check if the user is logged in
     * @return mixed
     */
    public function check()
    {
        return $this->guard->user();
    }
}
