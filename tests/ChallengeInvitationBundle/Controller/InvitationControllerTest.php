<?php

namespace ChallengeInvitationBundle\Tests\Controller;

use Tests\AppBundle\DataFixtures\DataFixtureTestCase;

class InvitationControllerTest extends DataFixtureTestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testIndex()
    {

        $crawler = $this->client->request('GET', '/invitation/all');

        $this->assertContains('Hello World', $this->client->getResponse()->getContent());
    }
}
