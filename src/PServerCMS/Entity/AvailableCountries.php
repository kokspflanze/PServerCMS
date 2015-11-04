<?php

namespace PServerCMS\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AvailableCountries
 * @ORM\Table(name="available_countries", indexes={@ORM\Index(name="fk_availableCountrys_users1_idx", columns={"users_usrId"})})
 * @ORM\Entity(repositoryClass="PServerCMS\Entity\Repository\AvailableCountries")
 */
class AvailableCountries
{
    /**
     * @var integer
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $acid;

    /**
     * @var string
     * @ORM\Column(name="cntry", type="string", length=45, nullable=false)
     */
    private $cntry;

    /**
     * @var string
     * @ORM\Column(name="active", type="string", nullable=false)
     */
    private $active = '1';

    /**
     * @var \DateTime
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    private $created;

    /**
     * @var UserInterface
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="users_usrId", referencedColumnName="usrId")
     * })
     */
    private $user;

    public function __construct()
    {
        $this->created = new \DateTime();
    }

    /**
     * Get acid
     * @return integer
     */
    public function getAcid()
    {
        return $this->acid;
    }

    /**
     * Set cntry
     * @param string $cntry
     * @return self
     */
    public function setCntry($cntry)
    {
        $this->cntry = $cntry;

        return $this;
    }

    /**
     * Get cntry
     * @return string
     */
    public function getCntry()
    {
        return $this->cntry;
    }

    /**
     * Set active
     * @param string $active
     * @return self
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     * @return string
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set created
     * @param \DateTime $created
     * @return self
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set user
     * @param UserInterface $user
     * @return self
     */
    public function setUser(UserInterface $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     * @return UserInterface
     */
    public function getUser()
    {
        return $this->user;
    }
}
