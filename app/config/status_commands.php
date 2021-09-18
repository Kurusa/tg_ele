<?php

use App\Commands\MainMenu\Feedback\{HaveProposal, LeaveReview};
use App\Services\Status\UserStatusService;

return [
    UserStatusService::LEAVE_REVIEW => LeaveReview::class,
    UserStatusService::HAVE_PROPOSAL => HaveProposal::class,

    UserStatusService::CAKE_DESCRIPTION => App\Commands\MainMenu\WantCake\WhatNeeded::class,
    UserStatusService::CAKE_PHOTO => App\Commands\MainMenu\WantCake\Photo::class,
    UserStatusService::CAKE_NAME => App\Commands\MainMenu\WantCake\Name::class,
    UserStatusService::CAKE_PHONE => App\Commands\MainMenu\WantCake\PhoneNumber::class,
    UserStatusService::CAKE_ADDRESS => App\Commands\MainMenu\WantCake\Address::class,
    UserStatusService::CAKE_DATE => App\Commands\MainMenu\WantCake\WhenNeeded::class,
    UserStatusService::CAKE_PAYMENT_TYPE => App\Commands\MainMenu\WantCake\PaymentType::class,
    
    UserStatusService::ORDER_DESCRIPTION => App\Commands\MainMenu\Order\WhatNeeded::class,
    UserStatusService::ORDER_NAME => App\Commands\MainMenu\Order\Name::class,
    UserStatusService::ORDER_PHONE => App\Commands\MainMenu\Order\PhoneNumber::class,
    UserStatusService::ORDER_ADDRESS => App\Commands\MainMenu\Order\Address::class,
    UserStatusService::ORDER_DATE => App\Commands\MainMenu\Order\WhenNeeded::class,
    UserStatusService::ORDER_PAYMENT_TYPE => App\Commands\MainMenu\Order\PaymentType::class,
];