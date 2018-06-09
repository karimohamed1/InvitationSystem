<?php
namespace AppBundle\DataFixtures;

use ChallengeUserBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadUserData extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i < 11; $i++) {
            $user = new User('user'.$i);
            $manager->persist($user);
        }
        $manager->flush();
    }
}