<?php namespace Modules\User\Repositories\Sentry;

use Cartalyst\Sentry\Facades\Laravel\Sentry;
use Cartalyst\Sentry\Users\UserNotFoundException;
use Modules\User\Exceptions\UserNotFoundException as BaseUserNotFoundException;
use Modules\User\Repositories\UserRepository;

class SentryUserRepository implements UserRepository
{
    /**
     * Returns all the users
     * @return object
     */
    public function all()
    {
        return Sentry::findAllUsers();
    }

    /**
     * Create a user resource
     * @param  array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return Sentry::createUser($data);
    }

    /**
     * Create a user and assign roles to it
     * @param array $data
     * @param array $roles
     * @param bool  $activated
     */
    public function createWithRoles($data, $roles, $activated = false)
    {
        $user = Sentry::createUser(array_merge($data, ['activated' => $activated]));
        $user->activated = $activated ? 1 : 0;
        $user->save();
        if (!empty($roles)) {
            foreach ($roles as $roleId) {
                $group = Sentry::findGroupById($roleId);
                $user->addGroup($group);
            }
        }
    }

    /**
     * Find a user by its ID
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return Sentry::findUserById($id);
    }

    /**
     * Update a user
     * @param $user
     * @param $data
     * @return mixed
     */
    public function update($user, $data)
    {
        return $user->update($data);
    }

    /**
     * Update a user and sync its roles
     * @param  int   $userId
     * @param $data
     * @param $roles
     * @return mixed
     */
    public function updateAndSyncRoles($userId, $data, $roles)
    {
        $user = Sentry::findUserById($userId);

        $this->checkForNewPassword($data);

        $user->update($data);

        if (!empty($roles)) {
            // Get the user roles
            $userRoles = $user->groups()->get()->toArray();
            $cleanedRoles = [];
            foreach ($userRoles as $role) {
                $cleanedRoles[$role['id']] = $role;
            }
            // Set the new roles
            foreach ($roles as $roleId) {
                if (isset($cleanedRoles[$roleId])) {
                    unset($cleanedRoles[$roleId]);
                }
                $group = Sentry::findGroupById($roleId);
                $user->addGroup($group);
            }
            // Unset the unchecked roles
            foreach ($cleanedRoles as $roleId => $role) {
                $group = Sentry::findGroupById($roleId);
                $user->removeGroup($group);
            }
        }
    }

    /**
     * Deletes a user
     * @param $id
     * @return mixed
     * @throws UserNotFoundException
     */
    public function delete($id)
    {
        if ($user = Sentry::findUserById($id)) {
            return $user->delete();
        };
        throw new UserNotFoundException();
    }

    /**
     * Find a user by its credentials
     * @param  array $credentials
     * @return mixed
     * @throws BaseUserNotFoundException
     */
    public function findByCredentials(array $credentials)
    {
        try {
            $user = Sentry::findUserByCredentials($credentials);
        } catch (\Exception $e) {
            throw new BaseUserNotFoundException();
        }

        return $user;
    }

    /**
     * Check if there is a new password given
     * If not, unset the password field
     * @param array $data
     */
    private function checkForNewPassword(array &$data)
    {
        if (! $data['password']) {
            unset($data['password']);
        }
    }
}
