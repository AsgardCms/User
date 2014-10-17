<?php namespace Modules\User\Http\Controllers\Admin;

use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class BaseUserModuleController extends AdminBaseController
{
    /**
     * @param $request
     * @return array
     */
    protected function mergeRequestWithPermissions($request)
    {
        return array_merge($request->all(), ['permissions' => $this->permissions->clean($request->permissions)]);
    }
}
