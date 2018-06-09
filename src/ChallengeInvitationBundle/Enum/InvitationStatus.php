<?php

namespace ChallengeInvitationBundle\Enum;

abstract class InvitationStatus {
    const PENDING = "Pending";
    const CANCELED = "Canceled";
    const ACCEPTED = "Accepted";
    const DECLINED = "Declined";
}