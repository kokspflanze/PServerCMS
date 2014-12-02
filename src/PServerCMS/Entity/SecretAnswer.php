<?php
/**
 * Created by PhpStorm.
 * User: †KôKšPfLâÑzè®
 * Date: 30.11.2014
 * Time: 21:24
 */

namespace PServerCMS\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SecretAnswer
 *
 * @ORM\Table(name="secretAnswer", indexes={@ORM\Index(name="fk_secretAnswer_users1_idx", columns={"user"}), @ORM\Index(name="fk_secretAnswer_secretQuestion_idx", columns={"question"})})
 * @ORM\Entity(repositoryClass="PServerCMS\Entity\Repository\SecretAnswer")
 */
class SecretAnswer {

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;

	/**
	 * @var \PServerCMS\Entity\Users
	 *
	 * @ORM\ManyToOne(targetEntity="PServerCMS\Entity\Users")
	 * @ORM\JoinColumns({
	 *   @ORM\JoinColumn(name="user", referencedColumnName="usrId")
	 * })
	 */
	private $user;

	/**
	 * @var SecretQuestion
	 *
	 * @ORM\ManyToOne(targetEntity="PServerCMS\Entity\SecretQuestion")
	 * @ORM\JoinColumns({
	 *   @ORM\JoinColumn(name="question", referencedColumnName="id")
	 * })
	 */
	private $question;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="answer", type="string", length=255, nullable=false)
	 */
	private $answer = '';

	/**
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getAnswer() {
		return $this->answer;
	}

	/**
	 * @param string $answer
	 *
	 * @return SecretAnswer
	 */
	public function setAnswer( $answer ) {
		$this->answer = $answer;

		return $this;
	}

	/**
	 * @return SecretQuestion
	 */
	public function getQuestion() {
		return $this->question;
	}

	/**
	 * @param SecretQuestion $question
	 *
	 * @return SecretAnswer
	 */
	public function setQuestion( SecretQuestion $question ) {
		$this->question = $question;

		return $this;
	}

	/**
	 * @return \PServerCMS\Entity\Users
	 */
	public function getUser() {
		return $this->user;
	}

	/**
	 * @param \PServerCMS\Entity\Users $user
	 *
	 * @return SecretAnswer
	 */
	public function setUser( \PServerCMS\Entity\Users $user ) {
		$this->user = $user;

		return $this;
	}



} 