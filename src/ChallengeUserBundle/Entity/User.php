<?php

namespace ChallengeUserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="ChallengeUserBundle\Repository\UserRepository")
 */
class User
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
     * @var string
     *
     * @ORM\Column(name="pseudoName", type="string", length=255, unique=true)
     */
    private $pseudoName;

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
     * @param string $pseudoName
     */
    public function setPseudoName($pseudoName)
    {
        $this->pseudoName = $pseudoName;
    }

    /**
     * @return string
     */
    public function getPseudoName()
    {
        return $this->pseudoName;
    }

    public function __toString()
    {
        return ''.$this->getPseudoName();
    }
}

