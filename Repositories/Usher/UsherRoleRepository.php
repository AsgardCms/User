<?php namespace Modules\User\Repositories\Usher;

use Modules\User\Repositories\RoleRepository;
use Maatwebsite\Usher\Contracts\Roles\RoleRepository as UsherRoleRepo;

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
        $role = $this->role->create($data);

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

        $role = $this->role->update($role, $data);

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
        return $this->role->delete($id);
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
