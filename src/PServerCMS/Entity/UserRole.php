<?php

namespace PServerCMS\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserRole
 * @ORM\Table(name="user_role", indexes={@ORM\Index(name="fk_users_role_users_role1_idx", columns={"parent_id"})})
 * @ORM\Entity(repositoryClass="PServerCMS\Entity\Repository\UserRole")
 */
class UserRole implements UserRoleInterface
{
    /**
     * @var integer
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="role_id", type="string", length=255, nullable=false)
     */
    private $roleId;

    /**
     * @var boolean
     * @ORM\Column(name="is_default", type="boolean", nullable=true)
     */
    private $isDefault;

    /**
     * @var string
     * @ORM\Column(name="parent_id", type="string", length=255, nullable=true)
     */
    private $parent;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToMany(targetEntity="User", inversedBy="userRole")
     * @ORM\JoinTable(name="user2role",
     *   joinColumns={
     *     @ORM\JoinColumn(name="user_role_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="users_usrId", referencedColumnName="usrId")
     *   }
     * )
     */
    private $user;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->user = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return UserRole
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set roleId
     * @param string $roleId
     * @return UserRole
     */
    public function setRoleId($roleId)
    {
        $this->roleId = $roleId;

        return $this;
    }

    /**
     * Get roleId
     * @return string
     */
    public function getRoleId()
    {
        return $this->roleId;
    }

    /**
     * Set isDefault
     * @param boolean $isDefault
     * @return UserRole
     */
    public function setIsDefault($isDefault)
    {
        $this->isDefault = $isDefault;

        return $this;
    }

    /**
     * Get isDefault
     * @return boolean
     */
    public function getIsDefault()
    {
        return $this->isDefault;
    }

    /**
     * Set parent
     * @param string $parent
     * @return UserRole
     */
    public function setParent($parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     * @return string
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add user
     * @param UserInterface $user
     * @return UserRole
     */
    public function addUser(UserInterface $user)
    {
        $this->user[] = $user;

        return $this;
    }

    /**
     * Remove user
     * @param UserInterface $user
     */
    public function removeUser(UserInterface $user)
    {
        $this->user->removeElement($user);
    }

    /**
     * Get User user
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUser()
    {
        return $this->user;
    }

}
