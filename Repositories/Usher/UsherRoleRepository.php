<?php namespace Modules\User\Repositories\Usher;

use Maatwebsite\Usher\Contracts\Roles\RoleRepository as UsherRoleRepo;
use Modules\User\Repositories\RoleRepository;

class UsherRoleRepository implements RoleRepository
{
    /**
     * @var UsherRoleRepo
     */
    protected $role;

    /**
     * @param UsherRoleRepo $role
     */
    public function __construct(UsherRoleRepo $role)
    {
        $this->role = $role;
    }

    /**
     * Return all the roles
     * @return mixed
     */
    public function all()
    {
        return $this->role->all();
    }

    /**
     * Create a role resource
     * @return mixed
     */
    public function create($data)
    {
        $entity = $this->role->getClassName();
        $role = new $entity;

        $role->create(
            $data['name'],
            $data['permissions']
        );

        $this->role->persist($role);
        $this->role->flush();

        return $role;
    }

    /**
     * Find a role by its id
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->role->find($id);
    }

    /**
     * Update a role
     * @param $id
     * @param $data
     * @return mixed
     */
    public function update($id, $data)
    {
        $role = $this->role->find($id);

        $role->update(
            $data['name'],
            $data['permissions']
        );

        $this->role->persist($role);
        $this->role->flush();

        return $role;
    }

    /**
     * Delete a role
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $role = $this->find($id);

        return $this->role->delete($role);
    }

    /**
     * Find a role by its name
     * @param  string $name
     * @return mixed
     */
    public function findByName($name)
    {
        return $this->role->findByName($name);
    }
}
