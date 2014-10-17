<?php namespace Modules\User\Http\Controllers\Admin;

use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Core\Permissions\PermissionManager;

class BaseUserModuleController extends AdminBaseController
{
    /**
     * @var PermissionManager
     */
    private $permissions;

    public function __construct(PermissionManager $permissions)
    {
        parent::__construct();

        $this->permissions = $permissions;
    }
    /**
     * @param $request
     * @return array
     */
    protected function mergeRequestWithPermissions($request)
    {
        return array_merge($request->all(), ['permissions' => $this->permissions->clean($request->permissions)]);
    }
}
