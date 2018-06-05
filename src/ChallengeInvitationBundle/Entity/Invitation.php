<?php

namespace ChallengeInvitationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Invitation
 *
 * @ORM\Table(name="invitation")
 * @ORM\Entity(repositoryClass="ChallengeInvitationBundle\Repository\InvitationRepository")
 */
class Invitation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="\ChallengeUserBundle\Entity\user"), cascade={"persist"}
     */
    private $sender;

    /**
     * @ORM\ManyToOne(targetEntity="\ChallengeUserBundle\Entity\user"), cascade={"persist"}
     */
    private $invited;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param \ChallengeUserBundle\Entity\user $sender
     *
     */
    public function setSender($sender)
    {
        $this->sender = $sender;
    }

    /**
     * @return \ChallengeUserBundle\Entity\user
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * @param \ChallengeUserBundle\Entity\user $invited
     *
     */
    public function setInvited($invited)
    {
        $this->invited = $invited;
    }

    /**
     * @return \ChallengeUserBundle\Entity\user
     */
    public function getInvited()
    {
        return $this->invited;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
}

