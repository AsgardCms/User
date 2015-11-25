<?php namespace Modules\User\Entities\Usher;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Laracasts\Presenter\PresentableTrait;
use Maatwebsite\Usher\Domain\Users\User as UsherUser;
use Modules\User\Entities\UserInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @ORM\HasLifecycleCallbacks()
 */
class User extends UsherUser implements UserInterface
{
    /**
     * Traits
     */
    use PresentableTrait;

    /**
     * @var string
     */
    protected $presenter = 'Modules\User\Presenters\UserPresenter';

    /**
     * @ORM\ManyToMany(targetEntity="Role", inversedBy="users")
     * @ORM\JoinTable(name="user_roles")
     * @var ArrayCollection|\Maatwebsite\Usher\Contracts\Roles\Role[]
     */
    protected $roles;

    /**
     * @return ArrayCollection|\Maatwebsite\Usher\Contracts\Roles\Role[]
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param ArrayCollection|Role[] $roles
     */
    public function setRoles(ArrayCollection $roles)
    {
        $this->roles = $roles;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->getName()->getFirstname();
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->getName()->getLastname();
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

    /**
     * Checks if a user belongs to the given Role ID
     * @param  int $roleId
     * @return bool
     */
    public function hasRoleId($roleId)
    {
    }

    /**
     * Checks if a user belongs to the given Role Name
     * @param  string $name
     * @return bool
     */
    public function hasRoleName($name)
    {
    }

    /**
     * Check if the current user is activated
     * @return bool
     */
    public function isActivated()
    {
    }
}
