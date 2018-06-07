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
    public function getActionAll()
    {
        $restresult = $this->getDoctrine()->getRepository('ChallengeInvitationBundle:Invitation')->findall();
        if ($restresult === null) {
            return new View("There are currently no invitations", Response::HTTP_NOT_FOUND);
        }
        return $restresult;
    }

    /**
     * @Rest\Post("/create")
     */
    public function invite(Request $request)
    {
        $senderPseudoName = $request->get('senderPseudoName');
        $invitedPseudoName = $request->get('invitedPseudoName');
        if(empty($senderPseudoName) || empty($invitedPseudoName) || !(isset($senderPseudoName) && isset($invitedPseudoName)))
        {
            return new View("The sender or the invited was not provided", Response::HTTP_NOT_ACCEPTABLE);
        }
        $sender = $this->getDoctrine()->getRepository('ChallengeUserBundle:User')->findOneBy(['pseudoName' => $senderPseudoName]);
        $invited = $this->getDoctrine()->getRepository('ChallengeUserBundle:User')->findOneBy(['pseudoName' => $invitedPseudoName]);
        if ($sender === null) {
            return new View("No user exists with the pseudo name ".$senderPseudoName, Response::HTTP_NOT_FOUND);
        }
        if ($invited === null) {
            return new View("No user exists with the pseudo name ".$invitedPseudoName, Response::HTTP_NOT_FOUND);
        }

        $invitation = new Invitation();
        $invitation->setSender($sender);
        $invitation->setInvited($invited);

        $em = $this->getDoctrine()->getManager();
        $em->persist($invitation);
        $em->flush();
        return new View("Invitation Added Successfully", Response::HTTP_OK);
    }
}

