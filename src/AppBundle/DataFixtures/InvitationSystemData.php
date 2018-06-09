<?php
namespace AppBundle\DataFixtures;

use ChallengeUserBundle\Entity\User;
use ChallengeInvitationBundle\Enum\InvitationStatus;
use ChallengeInvitationBundle\Entity\Invitation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class InvitationSystemData extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $users = array();

        for ($i = 0; $i < 15; $i++) {
            $user = new User();
            $user->setId('user'.$i);
            $manager->persist($user);
            $users[] = $user;
        }

        $invitationCombinations = array(
            array(2,3,InvitationStatus::PENDING),
            array(2,4,InvitationStatus::PENDING),
            array(2,5,InvitationStatus::ACCEPTED),
            array(2,10,InvitationStatus::DECLINED),

            array(3,4,InvitationStatus::PENDING),
            array(3,5,InvitationStatus::PENDING),
            array(3,10,InvitationStatus::PENDING),
            array(3,11,InvitationStatus::PENDING),

            array(4,5,InvitationStatus::PENDING),
            array(4,10,InvitationStatus::CANCELED),
            array(4,11,InvitationStatus::ACCEPTED),
            array(4,12,InvitationStatus::DECLINED),

            array(5,10,InvitationStatus::PENDING),
            array(5,11,InvitationStatus::CANCELED),
            array(5,11,InvitationStatus::ACCEPTED),
            array(5,13,InvitationStatus::DECLINED),

            array(6,2,InvitationStatus::DECLINED),

            array(7,2,InvitationStatus::ACCEPTED),
            array(7,3,InvitationStatus::DECLINED),

            array(8,2,InvitationStatus::CANCELED),
            array(8,3,InvitationStatus::ACCEPTED),
            array(8,4,InvitationStatus::PENDING),

            array(9,2,InvitationStatus::PENDING),
            array(9,3,InvitationStatus::CANCELED),
            array(9,4,InvitationStatus::PENDING),
            array(9,5,InvitationStatus::DECLINED),
        );

        foreach ($invitationCombinations as $invitationData){
            $invitation = new Invitation();
            $invitation->setSender($users[$invitationData[0]]);
            $invitation->setInvited($users[$invitationData[1]]);
            $invitation->setStatus($invitationData[2]);
            $manager->persist($invitation);
        }

        $manager->flush();
    }
}