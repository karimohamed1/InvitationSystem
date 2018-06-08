<?php

namespace ChallengeInvitationBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use ChallengeInvitationBundle\Entity\Invitation;

class InvitationController extends FOSRestController {

    /**
     * @Rest\Get("/all")
     */
    public function getAllAction()
    {
        $allInvitations = $this->getDoctrine()
            ->getRepository('ChallengeInvitationBundle:Invitation')
            ->findall();
        return $allInvitations ? $allInvitations : array();
    }

    /**
     * @Rest\Get("/sentBy/{senderId}")
     */
    public function getSentByAction($senderId)
    {
        $response = array();
        $sender = $this->getDoctrine()
            ->getRepository('ChallengeUserBundle:User')
            ->find($senderId);
        if($sender === null){
            $response["status"] = "error";
            $response["reason"] = "No user with the id $sender";
            return $response;
        }

        $invitations = $this->getDoctrine()
            ->getRepository('ChallengeInvitationBundle:Invitation')
            ->findBy(array('sender' => $sender));
        return $invitations ? $invitations : array();
    }

    /**
     * @Rest\Get("/receivedBy/{invitedId}")
     */
    public function getReceivedByAction($invitedId)
    {
        $response = array();
        $invited = $this->getDoctrine()
            ->getRepository('ChallengeUserBundle:User')
            ->find($invitedId);
        if($invited === null){
            $response["status"] = "error";
            $response["reason"] = "No user with the id $invitedId";
            return $response;
        }

        $invitations = $this->getDoctrine()
            ->getRepository('ChallengeInvitationBundle:Invitation')
            ->findBy(array('invited' => $invited));
        return $invitations ? $invitations : array();
    }
}