<?php

namespace App\Commands\MainMenu\WantCake;

use App\Commands\BaseCommand;
use App\Models\WantedCake;
use App\Services\Status\UserStatusService;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;

class WhatNeeded extends BaseCommand
{

    function processCommand()
    {
        if ($this->user->status === UserStatusService::CAKE_DESCRIPTION) {
            WantedCake::create([
                'user_id' => $this->user->id,
                'description' => $this->update->getMessage()->getText(),
            ]);
            $this->triggerCommand(Photo::class);
        } else {
            $this->user->status = UserStatusService::CAKE_DESCRIPTION;
            $this->user->save();

            $this->getBot()->sendMessageWithKeyboard($this->botUser->getId(), $this->translation->get('order_what_do_you_want'), new ReplyKeyboardMarkup([
                [$this->translation->get('main_menu')]
            ], false, true));
        }
    }

}