<?php

namespace App\Commands\MainMenu\Order;

use App\Commands\BaseCommand;
use App\Models\Order;
use App\Services\Status\UserStatusService;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;

class Address extends BaseCommand
{

    function processCommand()
    {
        if ($this->user->status === UserStatusService::ORDER_ADDRESS) {
            Order::where('user_id', $this->user->id)->where('status', 'NEW')->update([
                'address' => $this->update->getMessage()->getText()
            ]);
            $this->triggerCommand(WhenNeeded::class);
        } else {
            if ($this->user->status == UserStatusService::CAKE_ADDRESS) {
                $this->triggerCommand(\App\Commands\MainMenu\WantCake\Address::class);
                exit();
            }

            $this->user->status = UserStatusService::ORDER_ADDRESS;
            $this->user->save();

            $this->getBot()->sendMessageWithKeyboard($this->botUser->getId(), $this->translation->get('order_address_question'), new ReplyKeyboardMarkup([
                [$this->translation->get('order_pickup_address')],
                [$this->translation->get('main_menu')]
            ], false, true));
        }
    }

}