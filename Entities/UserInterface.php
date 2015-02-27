<?php namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Collection;
use Doctrine\Common\Collections\ArrayCollection;

interface UserInterface
{
    /**
     * Checks if a user belongs to the given Role ID
     * @param  int $roleId
     * @return bool
     */
    public function hasRole($roleId);
}
