<?php

namespace PServerCMS\Entity\TicketSystem;

use Doctrine\ORM\Mapping as ORM;
use SmallUser\Entity\UserInterface;
use ZfcTicketSystem\Entity\TicketSubject as ZfcTicketSubject;

/**
 * TicketEntry
 * @ORM\Table(name="ticket_entry", indexes={@ORM\Index(name="fk_ticketEntry_ticketSubject1_idx", columns={"ticket_subject"}),@ORM\Index(name="fk_ticketEntry_users1_idx", columns={"usrId"})})
 * @ORM\Entity(repositoryClass="ZfcTicketSystem\Entity\Repository\TicketEntry")
 */
class TicketEntry extends \ZfcTicketSystem\Entity\TicketEntry
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
     * @ORM\Column(name="memo", type="text", nullable=false)
     */
    private $memo;

    /**
     * @var UserInterface
     * @ORM\ManyToOne(targetEntity="PServerCMS\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usrId", referencedColumnName="usrId")
     * })
     */
    private $user;

    /**
     * @var ZfcTicketSubject
     * @ORM\ManyToOne(targetEntity="TicketSubject", inversedBy="ticketEntry")
     * @ORM\JoinColumn(name="ticket_subject", referencedColumnName="id")
     */
    private $subject;

    /**
     * @var \DateTime
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    private $created;

    public function __construct()
    {
        parent::__construct();
        $this->created = new \DateTime();
    }

    /**
     * @param $id
     * @return $this
     */
    public function setId($id)
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
     * Set memo
     * @param string $memo
     * @return TicketEntry
     */
    public function setMemo($memo)
    {
        $this->memo = $memo;

        return $this;
    }

    /**
     * Get memo
     * @return string
     */
    public function getMemo()
    {
        return $this->memo;
    }

    /**
     * Set user
     * @param UserInterface $user
     * @return TicketEntry
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

    /**
     * @return ZfcTicketSubject
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param ZfcTicketSubject $subject
     * @return TicketEntry
     */
    public function setSubject(ZfcTicketSubject $subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Set created
     * @param \DateTime $created
     * @return TicketEntry
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
}
