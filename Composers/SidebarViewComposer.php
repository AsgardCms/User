<?php namespace Modules\User\Composers;

use Illuminate\Contracts\View\View;
use Modules\Core\Composers\BaseSidebarViewComposer;

class SidebarViewComposer extends BaseSidebarViewComposer
{
    public function compose(View $view)
    {
        $view->sidebar->group(trans('workshop::workshop.title'), function ($group) {

            $group->addItem('Users', function ($item) {
                $item->weight = 0;
                $item->icon = 'fa fa-user';
                $item->authorize(
                    $this->auth->hasAccess('user.users.index') or $this->auth->hasAccess('user.roles.index')
                );

                $item->addItem(trans('user::users.title.users'), function ($item) {
                    $item->weight = 0;
                    $item->icon = 'fa fa-user';
                    $item->route('admin.user.user.index');
                    $item->authorize(
                        $this->auth->hasAccess('user.users.index')
                    );
                });

                $item->addItem(trans('user::roles.title.roles'), function ($item) {
                    $item->weight = 1;
                    $item->icon = 'fa fa-flag-o';
                    $item->route('admin.user.role.index');
                    $item->authorize(
                        $this->auth->hasAccess('user.roles.index')
                    );
                });
            });

        });
    }
}
