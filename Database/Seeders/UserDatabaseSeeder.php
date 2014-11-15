<?php namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class UserDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        foreach (Config::get('user::userdriver.seeder') as $seeder) {
            $this->call("Modules\\User\\Database\\Seeders\\" . Config::get('user::userdriver.driver') ."\\". $seeder);
        }
        //$this->call("Modules\\User\\Database\\Seeders\\SentryGroupSeedTableSeeder");
    }

}
