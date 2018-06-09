<?php

namespace ChallengeInvitationBundle\Tests\Controller;

use Tests\AppBundle\DataFixtures\DataFixtureTestCase;
use ChallengeInvitationBundle\Enum\InvitationStatus;

class InvitationControllerTest extends DataFixtureTestCase
{
    public function testGetAll()
    {
        $this->client->request('GET', '/api/invitation/all');
        $response = $this->client->getResponse()->getContent();
        $this->assertContains(json_encode(["id" =>  1, "sender" => ["id" => "user2"], "invited" => ["id" =>  "user3"], "status" => InvitationStatus::PENDING]), $response);
        $this->assertContains(json_encode(["id" =>  2, "sender" => ["id" => "user2"], "invited" => ["id" =>  "user4"], "status" => InvitationStatus::PENDING]), $response);
        $this->assertContains(json_encode(["id" =>  3, "sender" => ["id" => "user2"], "invited" => ["id" =>  "user5"], "status" => InvitationStatus::ACCEPTED]), $response);
        $this->assertContains(json_encode(["id" =>  4, "sender" => ["id" => "user2"], "invited" => ["id" => "user10"], "status" => InvitationStatus::DECLINED]), $response);
        $this->assertContains(json_encode(["id" =>  5, "sender" => ["id" => "user3"], "invited" => ["id" =>  "user4"], "status" => InvitationStatus::PENDING]), $response);
        $this->assertContains(json_encode(["id" =>  6, "sender" => ["id" => "user3"], "invited" => ["id" =>  "user5"], "status" => InvitationStatus::PENDING]), $response);
        $this->assertContains(json_encode(["id" =>  7, "sender" => ["id" => "user3"], "invited" => ["id" => "user10"], "status" => InvitationStatus::PENDING]), $response);
        $this->assertContains(json_encode(["id" =>  8, "sender" => ["id" => "user3"], "invited" => ["id" => "user11"], "status" => InvitationStatus::PENDING]), $response);
        $this->assertContains(json_encode(["id" =>  9, "sender" => ["id" => "user4"], "invited" => ["id" =>  "user5"], "status" => InvitationStatus::PENDING]), $response);
        $this->assertContains(json_encode(["id" => 10, "sender" => ["id" => "user4"], "invited" => ["id" => "user10"], "status" => InvitationStatus::CANCELED]), $response);
        $this->assertContains(json_encode(["id" => 11, "sender" => ["id" => "user4"], "invited" => ["id" => "user11"], "status" => InvitationStatus::ACCEPTED]), $response);
        $this->assertContains(json_encode(["id" => 12, "sender" => ["id" => "user4"], "invited" => ["id" => "user12"], "status" => InvitationStatus::DECLINED]), $response);
        $this->assertContains(json_encode(["id" => 13, "sender" => ["id" => "user5"], "invited" => ["id" => "user10"], "status" => InvitationStatus::PENDING]), $response);
        $this->assertContains(json_encode(["id" => 14, "sender" => ["id" => "user5"], "invited" => ["id" => "user11"], "status" => InvitationStatus::CANCELED]), $response);
        $this->assertContains(json_encode(["id" => 15, "sender" => ["id" => "user5"], "invited" => ["id" => "user11"], "status" => InvitationStatus::ACCEPTED]), $response);
        $this->assertContains(json_encode(["id" => 16, "sender" => ["id" => "user5"], "invited" => ["id" => "user13"], "status" => InvitationStatus::DECLINED]), $response);
        $this->assertContains(json_encode(["id" => 17, "sender" => ["id" => "user6"], "invited" => ["id" =>  "user2"], "status" => InvitationStatus::DECLINED]), $response);
        $this->assertContains(json_encode(["id" => 18, "sender" => ["id" => "user7"], "invited" => ["id" =>  "user2"], "status" => InvitationStatus::ACCEPTED]), $response);
        $this->assertContains(json_encode(["id" => 19, "sender" => ["id" => "user7"], "invited" => ["id" =>  "user3"], "status" => InvitationStatus::DECLINED]), $response);
        $this->assertContains(json_encode(["id" => 20, "sender" => ["id" => "user8"], "invited" => ["id" =>  "user2"], "status" => InvitationStatus::CANCELED]), $response);
        $this->assertContains(json_encode(["id" => 21, "sender" => ["id" => "user8"], "invited" => ["id" =>  "user3"], "status" => InvitationStatus::ACCEPTED]), $response);
        $this->assertContains(json_encode(["id" => 22, "sender" => ["id" => "user8"], "invited" => ["id" =>  "user4"], "status" => InvitationStatus::PENDING]), $response);
        $this->assertContains(json_encode(["id" => 23, "sender" => ["id" => "user9"], "invited" => ["id" =>  "user2"], "status" => InvitationStatus::PENDING]), $response);
        $this->assertContains(json_encode(["id" => 24, "sender" => ["id" => "user9"], "invited" => ["id" =>  "user3"], "status" => InvitationStatus::CANCELED]), $response);
        $this->assertContains(json_encode(["id" => 25, "sender" => ["id" => "user9"], "invited" => ["id" =>  "user4"], "status" => InvitationStatus::PENDING]), $response);
        $this->assertContains(json_encode(["id" => 26, "sender" => ["id" => "user9"], "invited" => ["id" =>  "user5"], "status" => InvitationStatus::DECLINED]), $response);
    }

    public function testGetSentBy(){
        $this->client->request('Put', '/api/user/user3/cancel/6');
        $this->client->request('Put', '/api/user/user10/accept/7');
        $this->client->request('Put', '/api/user/user11/decline/8');
        $this->client->request('GET', '/api/invitation/sentBy/user3');
        $response = $this->client->getResponse()->getContent();
        $this->assertContains(json_encode(["id" => 5, "sender" => ["id" => "user3"], "invited" => ["id" =>  "user4"], "status" => InvitationStatus::PENDING]), $response);
        $this->assertContains(json_encode(["id" => 6, "sender" => ["id" => "user3"], "invited" => ["id" =>  "user5"], "status" => InvitationStatus::CANCELED]), $response);
        $this->assertContains(json_encode(["id" => 7, "sender" => ["id" => "user3"], "invited" => ["id" => "user10"], "status" => InvitationStatus::ACCEPTED]), $response);
        $this->assertContains(json_encode(["id" => 8, "sender" => ["id" => "user3"], "invited" => ["id" => "user11"], "status" => InvitationStatus::DECLINED]), $response);
    }

    public function testGetReceivedBy(){
        $this->client->request('Put', '/api/user/user9/cancel/25');
        $this->client->request('Put', '/api/user/user4/accept/2');
        $this->client->request('Put', '/api/user/user4/decline/22');
        $this->client->request('GET', '/api/invitation/receivedBy/user4');
        $response = $this->client->getResponse()->getContent();
        $this->assertContains(json_encode(["id" =>  5, "sender" => ["id" => "user3"], "invited" => ["id" => "user4"], "status" => InvitationStatus::PENDING]), $response);
        $this->assertContains(json_encode(["id" =>  2, "sender" => ["id" => "user2"], "invited" => ["id" => "user4"], "status" => InvitationStatus::ACCEPTED]), $response);
        $this->assertContains(json_encode(["id" => 25, "sender" => ["id" => "user9"], "invited" => ["id" => "user4"], "status" => InvitationStatus::CANCELED]), $response);
        $this->assertContains(json_encode(["id" => 22, "sender" => ["id" => "user8"], "invited" => ["id" => "user4"], "status" => InvitationStatus::DECLINED]), $response);
    }
}
