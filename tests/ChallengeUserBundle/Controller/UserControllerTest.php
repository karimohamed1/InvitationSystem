<?php

namespace ChallengeUserBundle\Tests\Controller;

use Tests\AppBundle\DataFixtures\DataFixtureTestCase;

class UserControllerTest extends DataFixtureTestCase
{
    public function testGetAll()
    {
        $this->client->request('GET', '/api/user/all');
        $response = $this->client->getResponse()->getContent();
        $this->assertContains(json_encode(["id" => "user0"]), $response);
        $this->assertContains(json_encode(["id" => "user1"]), $response);
        $this->assertContains(json_encode(["id" => "user2"]), $response);
        $this->assertContains(json_encode(["id" => "user3"]), $response);
        $this->assertContains(json_encode(["id" => "user4"]), $response);
        $this->assertContains(json_encode(["id" => "user5"]), $response);
        $this->assertContains(json_encode(["id" => "user6"]), $response);
        $this->assertContains(json_encode(["id" => "user7"]), $response);
        $this->assertContains(json_encode(["id" => "user8"]), $response);
        $this->assertContains(json_encode(["id" => "user9"]), $response);
        $this->assertContains(json_encode(["id" => "user10"]), $response);
        $this->assertContains(json_encode(["id" => "user11"]), $response);
        $this->assertContains(json_encode(["id" => "user12"]), $response);
        $this->assertContains(json_encode(["id" => "user13"]), $response);
        $this->assertContains(json_encode(["id" => "user14"]), $response);
    }

    public function testInvite()
    {
        $this->client->request('Post', '/api/user/user0/invite/user1');
        $expectedStatus = 'ok';
        $response = json_decode($this->client->getResponse()->getContent());
        $this->assertEquals($expectedStatus, $response->status);


        $this->client->request('Post', '/api/user/user1/invite/user0');
        $expectedStatus = 'error';
        $expectedReason = 'A pending invitation exists already';
        $response = json_decode($this->client->getResponse()->getContent());
        $this->assertEquals($expectedStatus, $response->status);
        $this->assertEquals($expectedReason, $response->reason);

        $this->client->request('Post', '/api/user/user0/invite/user1');
        $expectedStatus = 'error';
        $expectedReason = 'A pending invitation exists already';
        $response = json_decode($this->client->getResponse()->getContent());
        $this->assertEquals($expectedStatus, $response->status);
        $this->assertEquals($expectedReason, $response->reason);

        $this->client->request('Post', '/api/user/user0/invite/user0');
        $expectedStatus = 'error';
        $expectedReason = 'A user may not invite himself';
        $response = json_decode($this->client->getResponse()->getContent());
        $this->assertEquals($expectedStatus, $response->status);
        $this->assertEquals($expectedReason, $response->reason);

        $this->client->request('Post', '/api/user/user0/invite/user15');
        $expectedStatus = 'error';
        $expectedReason = 'No user exists with the Id user15';
        $response = json_decode($this->client->getResponse()->getContent());
        $this->assertEquals($expectedStatus, $response->status);
        $this->assertEquals($expectedReason, $response->reason);
    }

    public function testCancel()
    {
        $this->client->request('Post', '/api/user/user0/invite/user1');
        $this->client->request('Put', '/api/user/user0/cancel/27');
        $expectedStatus = 'ok';
        $response = json_decode($this->client->getResponse()->getContent());
        $this->assertEquals($expectedStatus, $response->status);

        $this->client->request('Put', '/api/user/user0/cancel/27');
        $expectedStatus = 'error';
        $expectedReason = 'It\'s too late to cancel invitation 27 now';
        $response = json_decode($this->client->getResponse()->getContent());
        $this->assertEquals($expectedStatus, $response->status);
        $this->assertEquals($expectedReason, $response->reason);

        $this->client->request('Put', '/api/user/user1/cancel/27');
        $expectedStatus = 'error';
        $expectedReason = 'User user1 may not cancel invitations he didn\\\'t send';
        $response = json_decode($this->client->getResponse()->getContent());
        $this->assertEquals($expectedStatus, $response->status);
        $this->assertEquals($expectedReason, $response->reason);

        $this->client->request('Put', '/api/user/user0/cancel/28');
        $expectedStatus = 'error';
        $expectedReason = 'No invitation with the id 28';
        $response = json_decode($this->client->getResponse()->getContent());
        $this->assertEquals($expectedStatus, $response->status);
        $this->assertEquals($expectedReason, $response->reason);
    }

    public function testAccept()
    {
        $this->client->request('Post', '/api/user/user0/invite/user1');
        $this->client->request('Put', '/api/user/user1/accept/27');
        $expectedStatus = 'ok';
        $response = json_decode($this->client->getResponse()->getContent());
        $this->assertEquals($expectedStatus, $response->status);

        $this->client->request('Put', '/api/user/user1/accept/27');
        $expectedStatus = 'error';
        $expectedReason = 'It\'s too late to accept invitation 27 now';
        $response = json_decode($this->client->getResponse()->getContent());
        $this->assertEquals($expectedStatus, $response->status);
        $this->assertEquals($expectedReason, $response->reason);

        $this->client->request('Post', '/api/user/user1/invite/user2');
        $this->client->request('Put', '/api/user/user1/accept/28');
        $expectedStatus = 'error';
        $expectedReason = 'User user1 may not accept invitations he didn\\\'t receive';
        $response = json_decode($this->client->getResponse()->getContent());
        $this->assertEquals($expectedStatus, $response->status);
        $this->assertEquals($expectedReason, $response->reason);

        $this->client->request('Put', '/api/user/user2/accept/29');
        $expectedStatus = 'error';
        $expectedReason = 'No invitation with the id 29';
        $response = json_decode($this->client->getResponse()->getContent());
        $this->assertEquals($expectedStatus, $response->status);
        $this->assertEquals($expectedReason, $response->reason);
    }

    public function testDecline()
    {
        $this->client->request('Post', '/api/user/user0/invite/user1');
        $this->client->request('Put', '/api/user/user1/decline/27');
        $expectedStatus = 'ok';
        $response = json_decode($this->client->getResponse()->getContent());
        $this->assertEquals($expectedStatus, $response->status);

        $this->client->request('Put', '/api/user/user1/decline/27');
        $expectedStatus = 'error';
        $expectedReason = 'It\'s too late to decline invitation 27 now';
        $response = json_decode($this->client->getResponse()->getContent());
        $this->assertEquals($expectedStatus, $response->status);
        $this->assertEquals($expectedReason, $response->reason);

        $this->client->request('Post', '/api/user/user1/invite/user2');
        $this->client->request('Put', '/api/user/user1/decline/28');
        $expectedStatus = 'error';
        $expectedReason = 'User user1 may not decline invitations he didn\\\'t receive';
        $response = json_decode($this->client->getResponse()->getContent());
        $this->assertEquals($expectedStatus, $response->status);
        $this->assertEquals($expectedReason, $response->reason);

        $this->client->request('Put', '/api/user/user2/decline/29');
        $expectedStatus = 'error';
        $expectedReason = 'No invitation with the id 29';
        $response = json_decode($this->client->getResponse()->getContent());
        $this->assertEquals($expectedStatus, $response->status);
        $this->assertEquals($expectedReason, $response->reason);
    }

    public function testLateCancel()
    {
        $this->client->request('Post', '/api/user/user0/invite/user1');
        $this->client->request('Put', '/api/user/user1/decline/27');
        $this->client->request('Put', '/api/user/user0/cancel/27');
        $expectedStatus = 'error';
        $expectedReason = 'It\'s too late to cancel invitation 27 now';
        $response = json_decode($this->client->getResponse()->getContent());
        $this->assertEquals($expectedStatus, $response->status);
        $this->assertEquals($expectedReason, $response->reason);

        $this->client->request('Post', '/api/user/user1/invite/user2');
        $this->client->request('Put', '/api/user/user2/accept/28');
        $this->client->request('Put', '/api/user/user1/cancel/28');
        $expectedStatus = 'error';
        $expectedReason = 'It\'s too late to cancel invitation 28 now';
        $response = json_decode($this->client->getResponse()->getContent());
        $this->assertEquals($expectedStatus, $response->status);
        $this->assertEquals($expectedReason, $response->reason);
    }

    public function testLateAccept()
    {
        $this->client->request('Post', '/api/user/user0/invite/user1');
        $this->client->request('Put', '/api/user/user1/decline/27');
        $this->client->request('Put', '/api/user/user1/accept/27');
        $expectedStatus = 'error';
        $expectedReason = 'It\'s too late to accept invitation 27 now';
        $response = json_decode($this->client->getResponse()->getContent());
        $this->assertEquals($expectedStatus, $response->status);
        $this->assertEquals($expectedReason, $response->reason);

        $this->client->request('Post', '/api/user/user1/invite/user2');
        $this->client->request('Put', '/api/user/user1/cancel/28');
        $this->client->request('Put', '/api/user/user2/accept/28');
        $expectedStatus = 'error';
        $expectedReason = 'It\'s too late to accept invitation 28 now';
        $response = json_decode($this->client->getResponse()->getContent());
        $this->assertEquals($expectedStatus, $response->status);
        $this->assertEquals($expectedReason, $response->reason);
    }

    public function testLateDecline()
    {
        $this->client->request('Post', '/api/user/user0/invite/user1');
        $this->client->request('Put', '/api/user/user1/accept/27');
        $this->client->request('Put', '/api/user/user1/decline/27');
        $expectedStatus = 'error';
        $expectedReason = 'It\'s too late to decline invitation 27 now';
        $response = json_decode($this->client->getResponse()->getContent());
        $this->assertEquals($expectedStatus, $response->status);
        $this->assertEquals($expectedReason, $response->reason);

        $this->client->request('Post', '/api/user/user1/invite/user2');
        $this->client->request('Put', '/api/user/user1/cancel/28');
        $this->client->request('Put', '/api/user/user2/decline/28');
        $expectedStatus = 'error';
        $expectedReason = 'It\'s too late to decline invitation 28 now';
        $response = json_decode($this->client->getResponse()->getContent());
        $this->assertEquals($expectedStatus, $response->status);
        $this->assertEquals($expectedReason, $response->reason);
    }
}
