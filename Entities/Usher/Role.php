<?php namespace Modules\User\Entities\Usher;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Maatwebsite\Usher\Domain\Roles\Role as UsherRole;
use Maatwebsite\Usher\Contracts\Roles\Role as RoleInterface;

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

    /**
     * @param ArrayCollection $users
     */
    public function setUsers(ArrayCollection $users)
    {
        $this->users = $users;
    }
}
