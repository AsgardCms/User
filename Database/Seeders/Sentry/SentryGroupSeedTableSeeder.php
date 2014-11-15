<?php namespace Modules\User\Database\Seeders\Sentry;

use Cartalyst\Sentry\Facades\Laravel\Sentry;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class SentryGroupSeedTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // Create an Admin group
        Sentry::createGroup(
            [
                'name' => 'Admin',
            ]
        );

        // Create an Users group
        Sentry::createGroup(
            [
                'name' => 'User',
            ]
        );

        // Save the permissions
        $group = Sentry::findGroupByName('Admin');
        $group->permissions = [
            'dashboard.index' => true,
            'workbench.index' => true,
            'workbench.generate' => true,
            'workbench.migrate' => true,
            'workbench.install' => true,
            'workbench.seed' => true,
            'modules.index' => true,
            'modules.store' => true,
            'roles.index' => true,
            'roles.create' => true,
            'roles.store' => true,
            'roles.edit' => true,
            'roles.update' => true,
            'roles.destroy' => true,
            'users.index' => true,
            'users.create' => true,
            'users.store' => true,
            'users.edit' => true,
            'users.update' => true,
            'users.destroy' => true,
        ];
        $group->save();

        $group = Sentry::findGroupByName('User');
        $group->permissions = [
            'dashboard.index' => true
        ];
        $group->save();
    }

}
