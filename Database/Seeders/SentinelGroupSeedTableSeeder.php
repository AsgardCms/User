<?php namespace Modules\User\Database\Seeders;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class SentinelGroupSeedTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $groups = Sentinel::getRoleRepository();

        // Create an Admin group
        $groups->createModel()->create(
            [
                'name' => 'Admin',
                'slug' => 'admin',
            ]
        );

        // Create an Users group
        $groups->createModel()->create(
            [
                'name' => 'User',
                'slug' => 'user',
            ]
        );

        // Save the permissions
        $group = Sentinel::findRoleBySlug('admin');
        $group->permissions = [
            'dashboard.index' => true,
            'dashboard.grid.save' => true,
            'dashboard.grid.reset' => true,
            /* Workbench */
            'workshop.modules.index' => true,
            'workshop.modules.show' => true,
            'workshop.modules.disable' => true,
            'workshop.modules.enable' => true,
            'workshop.themes.index' => true,
            'workshop.themes.show' => true,
            /* Roles */
            'user.roles.index' => true,
            'user.roles.create' => true,
            'user.roles.store' => true,
            'user.roles.edit' => true,
            'user.roles.update' => true,
            'user.roles.destroy' => true,
            /* Users */
            'user.users.index' => true,
            'user.users.create' => true,
            'user.users.store' => true,
            'user.users.edit' => true,
            'user.users.update' => true,
            'user.users.destroy' => true,
            /* Menu */
            'menu.menus.index' => true,
            'menu.menus.create' => true,
            'menu.menus.store' => true,
            'menu.menus.edit' => true,
            'menu.menus.update' => true,
            'menu.menus.destroy' => true,
            'menu.menuitem.index' => true,
            'menu.menuitem.create' => true,
            'menu.menuitem.store' => true,
            'menu.menuitem.edit' => true,
            'menu.menuitem.update' => true,
            'menu.menuitem.destroy' => true,
            /* Media */
            'media.media.index' => true,
            'media.media.create' => true,
            'media.media.store' => true,
            'media.media.edit' => true,
            'media.media.update' => true,
            'media.media.destroy' => true,
            'media.media-grid.index' => true,
            'media.media-grid.ckIndex' => true,
            /* Settings */
            'setting.settings.index' => true,
            'setting.settings.store' => true,
            'setting.settings.getModuleSettings' => true,
            /* Page */
            'page.pages.index' => true,
            'page.pages.create' => true,
            'page.pages.store' => true,
            'page.pages.edit' => true,
            'page.pages.update' => true,
            'page.pages.destroy' => true,
            /* Translation */
            'translation.translations.index' => true,
            'translation.translations.update' => true,
            'translation.translations.export' => true,
            'translation.translations.import' => true,
        ];
        $group->save();

        $group = Sentinel::findRoleBySlug('user');
        $group->permissions = [
            'dashboard.index' => true,
        ];
        $group->save();
    }
}
