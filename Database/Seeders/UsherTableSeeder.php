<?php namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\User\Repositories\RoleRepository;

class UsherTableSeeder extends Seeder
{
    /**
     * @var RoleRepository
     */
    private $role;

    /**
     * @param RoleRepository $role
     */
    public function __construct(RoleRepository $role)
    {
        $this->role = $role;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->role->create(array(
            'name'        => 'Admin',
            'permissions' => [
                'dashboard.index' => 1,
                /* Workbench */
                'workshop.workbench.index' => 1,
                'workshop.workbench.generate' => 1,
                'workshop.workbench.migrate' => 1,
                'workshop.workbench.install' => 1,
                'workshop.workbench.seed' => 1,
                'workshop.modules.index' => 1,
                'workshop.modules.store' => 1,
                'workshop.generate.generate' => 1,
                'workshop.install.install' => 1,
                'workshop.migrate.migrate' => 1,
                'workshop.seed.seed' => 1,
                /* Roles */
                'user.roles.index' => 1,
                'user.roles.create' => 1,
                'user.roles.store' => 1,
                'user.roles.edit' => 1,
                'user.roles.update' => 1,
                'user.roles.destroy' => 1,
                /* Users */
                'user.users.index' => 1,
                'user.users.create' => 1,
                'user.users.store' => 1,
                'user.users.edit' => 1,
                'user.users.update' => 1,
                'user.users.destroy' => 1,
                /* Menu */
                'menu.menus.index' => 1,
                'menu.menus.create' => 1,
                'menu.menus.store' => 1,
                'menu.menus.edit' => 1,
                'menu.menus.update' => 1,
                'menu.menus.destroy' => 1,
                'menu.menuitem.index' => 1,
                'menu.menuitem.create' => 1,
                'menu.menuitem.store' => 1,
                'menu.menuitem.edit' => 1,
                'menu.menuitem.update' => 1,
                'menu.menuitem.destroy' => 1,
                /* Media */
                'media.media.index' => 1,
                'media.media.create' => 1,
                'media.media.store' => 1,
                'media.media.edit' => 1,
                'media.media.update' => 1,
                'media.media.destroy' => 1,
                /* Settings */
                'setting.settings.index' => 1,
                'setting.settings.store' => 1,
                'setting.settings.getModuleSettings' => 1,
                /* Page */
                'page.pages.index' => 1,
                'page.pages.create' => 1,
                'page.pages.store' => 1,
                'page.pages.edit' => 1,
                'page.pages.update' => 1,
                'page.pages.destroy' => 1,
            ],
        ));

        // Create an Users group
        $this->role->create(array(
            'name'        => 'User',
            'permissions' => [
                'dashboard.index' => 1,
            ],
        ));
    }
}
