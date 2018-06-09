<?php

namespace ChallengeUserBundle\Tests\Controller;

use Tests\AppBundle\DataFixtures\DataFixtureTestCase;

class UserControllerTest extends DataFixtureTestCase
{
    public function testIndex()
    {
        $crawler = $this->client->request('GET', '/user/all');

        $this->assertContains('Hello World', $this->client->getResponse()->getContent());
    }
}
