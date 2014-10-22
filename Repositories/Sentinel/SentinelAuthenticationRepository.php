<?php namespace Modules\User\Repositories\Sentinel;

use Modules\User\Repositories\AuthenticationRepository;

class SentinelAuthenticationRepository implements AuthenticationRepository
{
    /**
     * Authenticate a user
     * @param array $credentials
     * @param bool $remember Remember the user
     * @return mixed
     */
    public function login(array $credentials, $remember = false)
    {
        // TODO: Implement login() method.
    }

    /**
     * Register a new user.
     * @param array $user
     * @return bool
     */
    public function register(array $user)
    {
        // TODO: Implement register() method.
    }

    /**
     * Assign a role to the given user.
     * @param \Modules\User\Repositories\UserRepository $user
     * @param \Modules\User\Repositories\RoleRepository $role
     * @return mixed
     */
    public function assignRole($user, $role)
    {
        // TODO: Implement assignRole() method.
    }

    /**
     * Log the user out of the application.
     * @return mixed
     */
    public function logout()
    {
        // TODO: Implement logout() method.
    }
}
