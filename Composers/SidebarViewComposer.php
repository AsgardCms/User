<?php namespace Modules\User\Composers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;
use Modules\Core\Composers\BaseSidebarViewComposer;

class SidebarViewComposer extends BaseSidebarViewComposer
{
    public function compose(View $view)
    {
        $view->items->put('user', Collection::make([
            [
                'weight' => '1',
                'request' => Request::is("*/{$view->prefix}/user/users*") or Request::is("*/{$view->prefix}/user/roles*"),
                'route' => '#',
                'icon-class' => 'fa fa-user',
                'title' => 'Users & Roles',
                'permission' => $this->auth->hasAccess('user.users.index') or $this->auth->hasAccess('user.roles.index'),
            ],
            [
                'request' => "*/{$view->prefix}/user/users*",
                'route' => 'admin.user.user.index',
                'icon-class' => 'fa fa-user',
                'title' => 'Users',
                'permission' => $this->auth->hasAccess('user.users.index')
            ],
            [
                'request' => "*/{$view->prefix}/user/roles*",
                'route' => 'admin.user.role.index',
                'icon-class' => 'fa fa-flag-o',
                'title' => 'Roles',
                'permission' => $this->auth->hasAccess('user.roles.index')
            ],
        ]));
    }
}
