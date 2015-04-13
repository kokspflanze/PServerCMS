<?php

namespace PServerCMS\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CountryList
 * @ORM\Table(name="country_list")
 * @ORM\Entity(repositoryClass="PServerCMS\Entity\Repository\CountryList")
 */
class CountryList
{
    /**
     * @var integer
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     * @ORM\Column(name="ip_min", type="integer", nullable=false)
     */
    private $ipMin;

    /**
     * @var integer
     * @ORM\Column(name="ip_max", type="integer", nullable=false)
     */
    private $ipMax;

    /**
     * @var string
     * @ORM\Column(name="registry", type="string", length=45, nullable=false)
     */
    private $registry;

    /**
     * @var integer
     * @ORM\Column(name="assigned", type="integer", nullable=false)
     */
    private $assigned;

    /**
     * @var string
     * @ORM\Column(name="ctry", type="string", length=45, nullable=false)
     */
    private $ctry;

    /**
     * @var string
     * @ORM\Column(name="cntry", type="string", length=45, nullable=false)
     */
    private $cntry;

    /**
     * @var string
     * @ORM\Column(name="country", type="string", length=255, nullable=false)
     */
    private $country;


    /**
     * Get cid
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set ipMin
     * @param integer $ipMin
     * @return CountryList
     */
    public function setIpMin( $ipMin )
    {
        $this->ipMin = $ipMin;

        return $this;
    }

    /**
     * Get ipMin
     * @return integer
     */
    public function getIpMin()
    {
        return $this->ipMin;
    }

    /**
     * Set ipMax
     * @param integer $ipMax
     * @return CountryList
     */
    public function setIpMax( $ipMax )
    {
        $this->ipMax = $ipMax;

        return $this;
    }

    /**
     * Get ipMax
     * @return integer
     */
    public function getIpMax()
    {
        return $this->ipMax;
    }

    /**
     * Set registry
     * @param string $registry
     * @return CountryList
     */
    public function setRegistry( $registry )
    {
        $this->registry = $registry;

        return $this;
    }

    /**
     * Get registry
     * @return string
     */
    public function getRegistry()
    {
        return $this->registry;
    }

    /**
     * Set assigned
     * @param integer $assigned
     * @return CountryList
     */
    public function setAssigned( $assigned )
    {
        $this->assigned = $assigned;

        return $this;
    }

    /**
     * Get assigned
     * @return integer
     */
    public function getAssigned()
    {
        return $this->assigned;
    }

    /**
     * Set ctry
     * @param string $ctry
     * @return CountryList
     */
    public function setCtry( $ctry )
    {
        $this->ctry = $ctry;

        return $this;
    }

    /**
     * Get ctry
     * @return string
     */
    public function getCtry()
    {
        return $this->ctry;
    }

    /**
     * Set cntry
     * @param string $cntry
     * @return CountryList
     */
    public function setCntry( $cntry )
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
     * Set country
     * @param string $country
     * @return CountryList
     */
    public function setCountry( $country )
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }
}
