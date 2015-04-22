<?php namespace Modules\User\Entities;

interface UserInterface
{
    /**
     * Checks if a user belongs to the given Role ID
     * @param  int $roleId
     * @return bool
     */
    public function hasRole($roleId);

    /**
     * Check if the current user is activated
     * @return bool
     */
    public function isActivated();
}
