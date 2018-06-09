<?php

namespace ChallengeUserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use ChallengeInvitationBundle\Entity\Invitation;
use ChallengeUserBundle\Entity\User;

class UserController extends FOSRestController {

    /**
     * @Rest\Get("/all")
     */
    public function getAllAction()
    {
        $allUsers = $this->getDoctrine()->getRepository('ChallengeUserBundle:User')->findAll();
        return $allUsers ? $allUsers : [];
    }

    /**
     * @Rest\Post("/{senderId}/invite/{invitedId}")
     */
    public function inviteAction($senderId, $invitedId)
    {
        $response = array();
        if ($senderId === $invitedId){
            $response["status"] = "error";
            $response["reason"] = "A user may not invite himself";
            return $response;
        }

        $sender = $this->getDoctrine()
            ->getRepository('ChallengeUserBundle:User')
            ->find($senderId);
        $invited = $this->getDoctrine()
            ->getRepository('ChallengeUserBundle:User')
            ->find($invitedId);

        if ($sender === null) {
            $response["status"] = "error";
            $response["reason"] = "No user exists with the Id $senderId";
            return $response;
        }
        if ($invited === null) {
            $response["status"] = "error";
            $response["reason"] = "No user exists with the Id $invitedId";
            return $response;
        }

        $existingInvitation = $this->getDoctrine()
            ->getRepository('ChallengeInvitationBundle:Invitation')
            ->findOneBy(array('sender' => $sender, 'invited' => $invited, 'status' => 'Pending'));
        $existingEquivalentInvitation = $this->getDoctrine()
            ->getRepository('ChallengeInvitationBundle:Invitation')
            ->findOneBy(array('sender' => $invited, 'invited' => $sender, 'status' => 'Pending'));
        if($existingInvitation || $existingEquivalentInvitation ){
            $response["status"] = "error";
            $response["reason"] = "A pending invitation exists already";
            return $response;
        }

        $invitation = new Invitation();
        $invitation->setSender($sender);
        $invitation->setInvited($invited);
        $em = $this->getDoctrine()->getManager();
        $em->persist($invitation);
        $em->flush();

        $response["status"] = "ok";
        $response["reason"] = "Invitation sent";
        return $response;
    }

    /**
     * @Rest\Put("/{senderId}/cancel/{invitationId}")
     */
    public function cancelAction($senderId, $invitationId)
    {
        $response = array();
        $sender = $this->getDoctrine()
            ->getRepository('ChallengeUserBundle:User')
            ->find($senderId);

        if ($sender === null) {
            $response["status"] = "error";
            $response["reason"] = "No user with the id $senderId";
            return $response;
        }
        $invitation = $this->getDoctrine()
            ->getRepository('ChallengeInvitationBundle:Invitation')
            ->find($invitationId);
        if ($invitation === null) {
            $response["status"] = "error";
            $response["reason"] = "No invitation with the id $invitationId";
            return $response;
        }
        $realSender = $invitation->getSender();
        if($realSender->getId() !== $sender->getId()){
            $response["status"] = "error";
            $response["reason"] = "User $senderId may not cancel invitations he didn\'t send";
            return $response;
        }
        if($invitation->getStatus() !== "Pending"){
            $response["status"] = "error";
            $response["reason"] = "It's too late to cancel invitation $invitationId now";
            return $response;
        }

        $invitation->setStatus("Canceled");
        $em = $this->getDoctrine()->getManager();
        $em->persist($invitation);
        $em->flush();

        $response["status"] = "ok";
        $response["reason"] = "Invitation $invitationId is canceled";
        return $response;
    }

    /**
     * @Rest\Put("/{invitedId}/accept/{invitationId}")
     */
    public function acceptAction($invitedId, $invitationId)
    {
        $response = array();
        $invited = $this->getDoctrine()
            ->getRepository('ChallengeUserBundle:User')
            ->find($invitedId);
        if ($invited === null) {
            $response["status"] = "error";
            $response["reason"] = "No user with the id $invited";
            return $response;
        }

        $invitation = $this->getDoctrine()
            ->getRepository('ChallengeInvitationBundle:Invitation')
            ->find($invitationId);
        if ($invitation === null) {
            $response["status"] = "error";
            $response["reason"] = "No invitation with the id $invitationId";
            return $response;
        }

        if($invitation->getStatus() !== "Pending"){
            $response["status"] = "error";
            $response["reason"] = "It's too late to accept invitation $invitationId now";
            return $response;
        }

        $realInvited = $invitation->getInvited();
        if($invited->getId() !== $realInvited->getId()){
            $response["status"] = "error";
            $response["reason"] = "User $invitedId may not accept invitations he didn\'t receive";
            return $response;
        }

        $invitation->setStatus("Accepted");
        $em = $this->getDoctrine()->getManager();
        $em->persist($invitation);
        $em->flush();

        $response["status"] = "ok";
        $response["reason"] = "Invitation $invitationId is accepted";
        return $response;
    }

    /**
     * @Rest\Put("/{invitedId}/decline/{invitationId}")
     */
    public function declineAction($invitedId, $invitationId)
    {
        $response = array();
        $invited = $this->getDoctrine()
            ->getRepository('ChallengeUserBundle:User')
            ->find($invitedId);
        if ($invited === null) {
            $response["status"] = "error";
            $response["reason"] = "No user with the id $invited";
            return $response;
        }

        $invitation = $this->getDoctrine()
            ->getRepository('ChallengeInvitationBundle:Invitation')
            ->find($invitationId);
        if ($invitation === null) {
            $response["status"] = "error";
            $response["reason"] = "No invitation with the id $invitationId";
            return $response;
        }

        if($invitation->getStatus() !== "Pending"){
            $response["status"] = "error";
            $response["reason"] = "It's too late to decline invitation $invitationId now";
            return $response;
        }

        $realInvited = $invitation->getInvited();
        if($invited->getId() !== $realInvited->getId()){
            $response["status"] = "error";
            $response["reason"] = "User $invitedId may not decline invitations he didn\'t receive";
            return $response;
        }

        $invitation->setStatus("Declined");
        $em = $this->getDoctrine()->getManager();
        $em->persist($invitation);
        $em->flush();$response["status"] = "ok";
        $response["reason"] = "Invitation $invitationId is declined";
        return $response;
    }
}