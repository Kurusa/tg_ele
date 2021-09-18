<?php

namespace App\Commands\MainMenu\WantCake;

use App\Commands\BaseCommand;
use App\Models\WantedCake;
use App\Services\Status\UserStatusService;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;

class PhoneNumber extends BaseCommand
{

    function processCommand()
    {
        if ($this->user->status === UserStatusService::CAKE_PHONE) {
            WantedCake::where('user_id', $this->user->id)->where('status', 'NEW')->update([
                'phone_number' => $this->update->getMessage()->getText()
            ]);
            $this->triggerCommand(Address::class);
        } else {
            $this->user->status = UserStatusService::CAKE_PHONE;
            $this->user->save();

            $this->getBot()->sendMessageWithKeyboard($this->botUser->getId(), $this->translation->get('order_phone_number'), new ReplyKeyboardMarkup([
                [$this->translation->get('main_menu')]
            ], false, true));
        }
    }

}