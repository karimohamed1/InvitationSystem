<?php

namespace ChallengeUserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;

class UserController extends FOSRestController {

    /**
     * @Rest\Get("/all")
     */
    public function getAllAction()
    {
        $restresult = $this->getDoctrine()->getRepository('ChallengeUserBundle:User')->findAll();
        if ($restresult === null) {
            return new View("There are currently no users", Response::HTTP_NOT_FOUND);
        }
        return $restresult;
    }
}

