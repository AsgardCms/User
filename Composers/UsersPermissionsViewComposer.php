<?php

namespace Modules\User\Composers;

use Modules\Core\Contracts\Authentication;

class UsersPermissionsViewComposer
{
    /**
     * @var Authentication
     */
    private $authentication;

    public function __construct(Authentication $authentication)
    {
        $this->authentication = $authentication;
    }

    public function compose($view)
    {
        $permissions = [];

        if ($user = $this->authentication->check()) {
            $permissions = $user->permissions;
        }

        $view->with('usersPermissions', $permissions);
    }
}