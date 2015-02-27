<?php namespace Modules\User\Repositories\Usher;

use Maatwebsite\Usher\Domain\Users\Embeddables\Email;
use Maatwebsite\Usher\Domain\Users\Embeddables\Name;
use Maatwebsite\Usher\Domain\Users\Embeddables\Password;
use Modules\User\Repositories\UserRepository;
use Modules\User\Exceptions\UserNotFoundException;
use Maatwebsite\Usher\Contracts\Roles\RoleRepository;
use Maatwebsite\Usher\Contracts\Users\UserRepository as UsherUserRepo;

class UsherUserRepository implements UserRepository
{

    /**
     * @var UsherUserRepo
     */
    protected $user;

    /**
     * @var RoleRepository
     */
    protected $role;

    /**
     * @param UsherUserRepo  $user
     * @param RoleRepository $role
     */
    public function __construct(UsherUserRepo $user, RoleRepository $role)
    {
        $this->user = $user;
        $this->role = $role;
    }

    /**
     * Returns all the users
     * @return object
     */
    public function all()
    {
        return $this->user->all();
    }

    /**
     * Create a user resource
     * @param $data
     * @return mixed
     */
    public function create(array $data)
    {
        $entity = $this->user->getClassName();
        $user = new $entity;

        $name = new Name(
            $data['first_name'],
            $data['last_name']
        );

        $email = new Email(
            $data['email']
        );

        $password = new Password(
            $data['password']
        );

        $user = $user->register($name, $email, $password);

        $this->user->persist($user);
        $this->user->flush();

        return $user;
    }

    /**
     * Create a user and assign roles to it
     * @param  array $data
     * @param  array $roles
     * @return void
     */
    public function createWithRoles($data, $roles)
    {
        $user = $this->create((array) $data);

        if (!empty($roles)) {
            foreach ($roles as $id) {
                $role = $this->role->find($id);
                $user->assignRole($role);
            }
        }

        $this->user->persist($user);
        $this->user->flush();

        return $user;
    }

    /**
     * Find a user by its ID
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->user->find($id);
    }

    /**
     * Update a user
     * @param $user
     * @param $data
     * @return mixed
     */
    public function update($user, $data)
    {
        $name = new Name(
            $data['first_name'],
            $data['last_name']
        );

        $email = new Email(
            $data['email']
        );

        $password = new Password(
            $data['password']
        );

        if ($password->equals($user->getPassword())) {
            $password = null;
        }

        $user = $user->update($name, $email, $password);

        $this->user->persist($user);
        $this->user->flush();

        return $user;
    }

    /**
     * @param $userId
     * @param $data
     * @param $roles
     * @internal param $user
     * @return mixed
     */
    public function updateAndSyncRoles($userId, $data, $roles)
    {
        $user = $this->user->find($userId);
        $user = $this->update($user, $data);

        $roleInstances = [];
        if (!empty($roles)) {
            foreach ($roles as $id) {
                $roleInstances[] = $this->role->find($id);
            }
        }

        $user->syncRoles($roles);

        $this->user->persist($user);
        $this->user->flush();

        return $user;
    }

    /**
     * Deletes a user
     * @param $id
     * @throws UserNotFoundException
     * @return mixed
     */
    public function delete($id)
    {
        return $this->user->delete($id);
    }

    /**
     * Find a user by its credentials
     * @param  array $credentials
     * @return mixed
     */
    public function findByCredentials(array $credentials)
    {
        return $this->user->findByCredentials($credentials);
    }
}
