<?php

namespace PServerCMS\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserExtension
 *
 * @ORM\Table(name="user_extension", indexes={@ORM\Index(name="fk_userExtension_users1_idx", columns={"user_id"})})
 * @ORM\Entity
 */
class UserExtension
{
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="user_id", type="integer", nullable=false)
	 */
	private $userId;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="key", type="string", length=255, nullable=false)
	 */
	private $key;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="value", type="string", length=255, nullable=false)
	 */
	private $value;


	/**
	 * Get id
	 *
	 * @return integer
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Set key
	 *
	 * @param string $key
	 *
	 * @return UserExtension
	 */
	public function setKey( $key ) {
		$this->key = $key;

		return $this;
	}

	/**
	 * Get key
	 *
	 * @return string
	 */
	public function getKey() {
		return $this->key;
	}

	/**
	 * Set value
	 *
	 * @param string $value
	 *
	 * @return UserExtension
	 */
	public function setValue( $value ) {
		$this->value = $value;

		return $this;
	}

	/**
	 * Get value
	 *
	 * @return string
	 */
	public function getValue() {
		return $this->value;
	}

	/**
	 * Set userId
	 *
	 * @param integer $userId
	 *
	 * @return UserExtension
	 */
	public function setUserId( $userId ) {
		$this->userId = $userId;

		return $this;
	}

	/**
	 * Get userId
	 *
	 * @return integer
	 */
	public function getUserId() {
		return $this->userId;
	}
}
