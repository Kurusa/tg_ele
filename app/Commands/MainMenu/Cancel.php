<?php

namespace App\Commands\MainMenu;

use App\Commands\BaseCommand;
use App\Commands\Start;
use App\Models\Order;
use App\Models\WantedCake;
use App\Services\Status\UserStatusService;

class Cancel extends BaseCommand
{

    function processCommand()
    {
        switch ($this->user->status) {
            case UserStatusService::LEAVE_REVIEW:
            case UserStatusService::HAVE_PROPOSAL:
            case UserStatusService::CAKE_DESCRIPTION:
                $this->triggerCommand(Start::class);
                break;
            case UserStatusService::CAKE_DATE:
            case UserStatusService::CAKE_PHONE:
            case UserStatusService::CAKE_PAYMENT_TYPE:
            case UserStatusService::CAKE_NAME:
            case UserStatusService::CAKE_ADDRESS:
            case UserStatusService::CAKE_PHOTO:
                WantedCake::where('user_id', $this->user->id)->where('status', 'NEW')->delete();

                if ($this->update->getCallbackQuery()) {
                    $this->getBot()->deleteMessage($this->botUser->getId(), $this->update->getCallbackQuery()->getMessage()->getMessageId());
                }

                $this->triggerCommand(Start::class);
                break;
            case UserStatusService::ORDER_DATE:
            case UserStatusService::ORDER_PHONE:
            case UserStatusService::ORDER_PAYMENT_TYPE:
            case UserStatusService::ORDER_NAME:
            case UserStatusService::ORDER_ADDRESS:
            case UserStatusService::ORDER_DESCRIPTION:
                Order::where('user_id', $this->user->id)->where('status', 'NEW')->delete();

                if ($this->update->getCallbackQuery()) {
                    $this->getBot()->deleteMessage($this->botUser->getId(), $this->update->getCallbackQuery()->getMessage()->getMessageId());
                }

                $this->triggerCommand(Start::class);
                break;
        }
    }

}