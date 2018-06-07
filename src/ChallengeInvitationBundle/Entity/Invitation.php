<?php

namespace ChallengeInvitationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Invitation
 *
 * @ORM\Table(name="invitation")
 * @ORM\Entity(repositoryClass="ChallengeInvitationBundle\Repository\InvitationRepository")
 */
class Invitation
{
    /**
     * Invitation constructor.
     */
    public function __construct()
    {
        $this->status = 'Pending';
    }

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="\ChallengeUserBundle\Entity\User"), cascade={"persist"}
     */
    private $sender;

    /**
     * @ORM\ManyToOne(targetEntity="\ChallengeUserBundle\Entity\User"), cascade={"persist"}
     */
    private $invited;

    /**
     * @ORM\Column(name="status", type="string", nullable=true, options={"default" : "Pending"})
     * @Assert\Choice({"Pending", "Accepted", "Declined"})
     */
    private $status;

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param \ChallengeUserBundle\Entity\User $sender
     *
     */
    public function setSender($sender)
    {
        $this->sender = $sender;
    }

    /**
     * @return \ChallengeUserBundle\Entity\User
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * @param \ChallengeUserBundle\Entity\User $invited
     *
     */
    public function setInvited($invited)
    {
        $this->invited = $invited;
    }

    /**
     * @return \ChallengeUserBundle\Entity\User
     */
    public function getInvited()
    {
        return $this->invited;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function __toString()
    {
        return 'A '. $this->getStatus() . 'invitation from ' . $this->getSender() . ' to '.$this->getInvited();
    }
}

