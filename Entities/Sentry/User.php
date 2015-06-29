<?php namespace Modules\User\Entities\Sentry;

use Cartalyst\Sentry\Facades\Laravel\Sentry;
use Cartalyst\Sentry\Users\Eloquent\User as SentryModel;
use Illuminate\Support\Facades\Config;
use Laracasts\Presenter\PresentableTrait;
use Modules\User\Entities\UserInterface;

/**
 * @property bool activated
 */
class User extends SentryModel implements UserInterface
{
    use PresentableTrait;

    protected $fillable = [
        'email',
        'password',
        'permissions',
        'first_name',
        'last_name',
        'activated',
    ];

    protected $presenter = 'Modules\User\Presenters\UserPresenter';

    public function groups()
    {
        return $this->belongsToMany(static::$groupModel, static::$userGroupsPivot, 'user_id');
    }

    /**
     * Checks if a user belongs to the given Role ID
     * @param  int  $roleId
     * @return bool
     */
    public function hasRoleId($roleId)
    {
        $role = Sentry::findGroupById($roleId);

        return $this->inGroup($role);
    }

    /**
     * Checks if a user belongs to the given Role Name
     * @param  string $name
     * @return bool
     */
    public function hasRoleName($name)
    {
        $role = Sentry::findGroupByName($name);

        return $this->inGroup($role);
    }

    /**
     * Check if the current user is activated
     * @return bool
     */
    public function isActivated()
    {
        return (bool) $this->activated;
    }

    public function __call($method, $parameters)
    {
        $class_name = class_basename($this);

        #i: Convert array to dot notation
        $config = implode('.', ['relations', $class_name, $method]);

        #i: Relation method resolver
        if (Config::has($config)) {
            $function = Config::get($config);

            return $function($this);
        }

        #i: No relation found, return the call to parent (Eloquent) to handle it.
        return parent::__call($method, $parameters);
    }
}
