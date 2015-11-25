<?php namespace Modules\User\Http\Controllers\Admin;

use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\User\Permissions\PermissionManager;

abstract class BaseUserModuleController extends AdminBaseController
{
    /**
     * @var PermissionManager
     */
    protected $permissions;

    /**
     * @param $request
     * @return array
     */
    protected function mergeRequestWithPermissions($request)
    {
        $permissions = [];

        if (! $this->permissions->permissionsAreAllFalse($request->permissions)) {
            $permissions = $this->permissions->clean($request->permissions);
        }

        return array_merge($request->all(), [ 'permissions' => $permissions ]);
    }
}
