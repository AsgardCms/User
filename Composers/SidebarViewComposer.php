<?php namespace Modules\User\Composers;

use Illuminate\Contracts\View\View;
use Modules\Core\Composers\BaseSidebarViewComposer;

class SidebarViewComposer extends BaseSidebarViewComposer
{
    public function compose(View $view)
    {
        $view->sidebar->group('Users', function($group) {
            $group->weight = 1;
            $group->authorize(
                $this->auth->hasAccess('user.users.index') or $this->auth->hasAccess('user.roles.index')
            );

            $group->addItem('Users', function($item) {

                $item->addItem('users', function($item) {
                    $item->route('admin.user.user.index');
                    $item->icon = 'fa fa-user';
                    $item->name = 'Users';
                    $item->authorize(
                        $this->auth->hasAccess('user.users.index')
                    );
                });

                $item->addItem('roles', function($item) {
                    $item->route('admin.user.role.index');
                    $item->icon = 'fa fa-flag-o';
                    $item->name = 'Roles';
                    $item->authorize(
                        $this->auth->hasAccess('user.roles.index')
                    );
                });
            });

        });
    }
}
