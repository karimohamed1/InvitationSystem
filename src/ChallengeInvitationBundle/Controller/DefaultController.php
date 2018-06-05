<?php

namespace ChallengeInvitationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/invitation")
     */
    public function indexAction()
    {
        return $this->render('ChallengeInvitationBundle:Default:index.html.twig');
    }
}
