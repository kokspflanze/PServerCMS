<?php

namespace PServerCMS\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SecretAnswer
 * @ORM\Table(name="secret_answer", indexes={@ORM\Index(name="fk_secretAnswer_users1_idx", columns={"user"}), @ORM\Index * (name="fk_secretAnswer_secretQuestion_idx", columns={"question"})})
 * @ORM\Entity(repositoryClass="PServerCMS\Entity\Repository\SecretAnswer")
 */
class SecretAnswer
{
    /**
     * @var integer
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var UserInterface
     * @ORM\ManyToOne(targetEntity="PServerCMS\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user", referencedColumnName="usrId")
     * })
     */
    private $user;

    /**
     * @var SecretQuestion
     * @ORM\ManyToOne(targetEntity="PServerCMS\Entity\SecretQuestion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="question", referencedColumnName="id")
     * })
     */
    private $question;

    /**
     * @var string
     * @ORM\Column(name="answer", type="string", length=255, nullable=false)
     */
    private $answer = '';

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * @param string $answer
     * @return SecretAnswer
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;

        return $this;
    }

    /**
     * @return SecretQuestion
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @param SecretQuestion $question
     * @return SecretAnswer
     */
    public function setQuestion(SecretQuestion $question)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * @return UserInterface
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param UserInterface $user
     * @return SecretAnswer
     */
    public function setUser(UserInterface $user)
    {
        $this->user = $user;

        return $this;
    }


}