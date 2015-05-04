<?php

namespace PServerCMS\Entity\TicketSystem;

use Doctrine\ORM\Mapping as ORM;

/**
 * TicketCategory
 * @ORM\Table(name="ticket_category")
 * @ORM\Entity(repositoryClass="ZfcTicketSystem\Entity\Repository\TicketCategory")
 */
class TicketCategory extends \ZfcTicketSystem\Entity\TicketCategory
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
     * @ORM\Column(name="subject", type="string", length=45, nullable=false)
     */
    private $subject;

    /**
     * @var integer
     * @ORM\Column(name="sort_key", type="smallint", nullable=false)
     */
    private $sortKey;

    /**
     * @var string
     * @ORM\Column(name="active", type="string", length=1, nullable=false)
     */
    private $active;

    /**
     * @param $id
     * @return $this
     */
    public function setId( $id )
    {
        $this->id = $id;

        return $this;
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
     * Set subject
     * @param string $subject
     * @return TicketCategory
     */
    public function setSubject( $subject )
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set sortKey
     * @param integer $sortKey
     * @return TicketCategory
     */
    public function setSortKey( $sortKey )
    {
        $this->sortKey = $sortKey;

        return $this;
    }

    /**
     * Get sortKey
     * @return integer
     */
    public function getSortKey()
    {
        return $this->sortKey;
    }

    /**
     * Set active
     * @param string $active
     * @return TicketCategory
     */
    public function setActive( $active )
    {
        $this->active = (string) $active;

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
}
