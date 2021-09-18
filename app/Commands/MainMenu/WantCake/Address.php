<?php

namespace App\Commands\MainMenu\WantCake;

use App\Commands\BaseCommand;
use App\Models\Order;
use App\Models\WantedCake;
use App\Services\Status\UserStatusService;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;

class Address extends BaseCommand
{

    function processCommand()
    {
        if ($this->user->status === UserStatusService::CAKE_ADDRESS) {
            WantedCake::where('user_id', $this->user->id)->where('status', 'NEW')->update([
                'address' => $this->update->getMessage()->getText()
            ]);
            $this->triggerCommand(WhenNeeded::class);
        } else {
            $this->user->status = UserStatusService::CAKE_ADDRESS;
            $this->user->save();

            $this->getBot()->sendMessageWithKeyboard($this->botUser->getId(), $this->translation->get('order_address_question'), new ReplyKeyboardMarkup([
                [$this->translation->get('order_pickup_address')],
                [$this->translation->get('main_menu')]
            ], false, true));
        }
    }

}