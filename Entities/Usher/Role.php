<?php namespace Modules\User\Entities\Usher;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Maatwebsite\Usher\Contracts\Roles\Role as RoleInterface;
use Maatwebsite\Usher\Domain\Roles\Role as UsherRole;

/**
 * @ORM\Entity
 * @ORM\Table(name="roles")
 * @ORM\HasLifecycleCallbacks()
 */
class Role extends UsherRole implements RoleInterface
{
    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="roles")
     * @var ArrayCollection|\Maatwebsite\Usher\Contracts\Users\User[]
     **/
    protected $users;

    /**
     * @return ArrayCollection
     */
    public function getUsers()
    {
        return $this->users;
    }

    public function users()
    {
        return $this->getUsers();
    }

    /**
     * @param ArrayCollection $users
     */
    public function setUsers(ArrayCollection $users)
    {
        $this->users = $users;
    }

    /**
     * @param $attribute
     * @return null|string
     */
    public function __get($attribute)
    {
        $method = 'get' . studly_case($attribute);

        if (method_exists($this, $method)) {
            return $this->{$method}();
        }

        return null;
    }

    /**
     * @param $attribute
     * @return bool
     */
    public function __isset($attribute)
    {
        $method = 'get' . studly_case($attribute);

        if (method_exists($this, $method)) {
            return true;
        }

        return false;
    }
}
