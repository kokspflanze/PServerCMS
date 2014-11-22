<?php

namespace PServerCMS\Entity;

use BjyAuthorize\Acl\HierarchicalRoleInterface;
use Doctrine\ORM\Mapping as ORM;
use SmallUser\Entity\UserRoleInterface;
use SmallUser\Entity\UsersInterface;

/**
 * UserRole
 *
 * @ORM\Table(name="user_role", indexes={@ORM\Index(name="fk_users_role_users_role1_idx", columns={"parent_id"})})
 * @ORM\Entity
 */
class UserRole implements HierarchicalRoleInterface, UserRoleInterface {
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="role_id", type="string", length=255, nullable=false)
	 */
	private $roleId;

	/**
	 * @var boolean
	 *
	 * @ORM\Column(name="is_default", type="boolean", nullable=true)
	 */
	private $isDefault;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="parent_id", type="string", length=255, nullable=true)
	 */
	private $parent;

	/**
	 * @var \Doctrine\Common\Collections\Collection
	 *
	 * @ORM\ManyToMany(targetEntity="PServerCMS\Entity\Users", inversedBy="userRole")
	 * @ORM\JoinTable(name="user2role",
	 *   joinColumns={
	 *     @ORM\JoinColumn(name="user_role_id", referencedColumnName="id")
	 *   },
	 *   inverseJoinColumns={
	 *     @ORM\JoinColumn(name="users_usrId", referencedColumnName="usrId")
	 *   }
	 * )
	 */
	private $usersUsrid;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->usersUsrid = new \Doctrine\Common\Collections\ArrayCollection();
	}


	/**
	 * Get id
	 *
	 * @return integer
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Set roleId
	 *
	 * @param string $roleId
	 *
	 * @return UserRole
	 */
	public function setRoleId( $roleId ) {
		$this->roleId = $roleId;

		return $this;
	}

	/**
	 * Get roleId
	 *
	 * @return string
	 */
	public function getRoleId() {
		return $this->roleId;
	}

	/**
	 * Set isDefault
	 *
	 * @param boolean $isDefault
	 *
	 * @return UserRole
	 */
	public function setIsDefault( $isDefault ) {
		$this->isDefault = $isDefault;

		return $this;
	}

	/**
	 * Get isDefault
	 *
	 * @return boolean
	 */
	public function getIsDefault() {
		return $this->isDefault;
	}

	/**
	 * Set parent
	 *
	 * @param string $parent
	 *
	 * @return UserRole
	 */
	public function setParent( $parent ) {
		$this->parent = $parent;

		return $this;
	}

	/**
	 * Get parent
	 *
	 * @return string
	 */
	public function getParent() {
		return $this->parent;
	}

	/**
	 * Add usersUsrid
	 *
	 * @param UsersInterface $user
	 *
	 * @return UserRole
	 */
	public function addUsersUsrid( UsersInterface $user ) {
		$this->usersUsrid[] = $user;

		return $this;
	}

	/**
	 * Remove usersUsrid
	 *
	 * @param UsersInterface $user
	 */
	public function removeUsersUsrid( UsersInterface $user ) {
		$this->usersUsrid->removeElement( $user );
	}

	/**
	 * Get Users usersUsrid
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getUsersUsrid() {
		return $this->usersUsrid;
	}

}
