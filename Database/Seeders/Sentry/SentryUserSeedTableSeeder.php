<?php namespace Modules\User\Database\Seeders\Sentry;

use Cartalyst\Sentry\Facades\Laravel\Sentry;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class SentryUserSeedTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // Create an admin user
        $user = Sentry::createUser(
            [
                'email' => 'n.widart@gmail.com',
                'password' => 'test',
                'first_name' => 'Nicolas',
                'last_name' => 'Widart'
            ]
        );
        // Activate the admin directly
        $code = $user->getResetPasswordCode();
        $user->attemptActivation($code);

        // Find the group using the group id
        $adminGroup = Sentry::findGroupByName('Admin');

        // Assign the group to the user
        $adminGroup->users()->attach($user);
    }

}
