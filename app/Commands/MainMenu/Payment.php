<?php

namespace App\Commands\MainMenu;

use App\Commands\BaseCommand;
use App\Models\Ad;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;

class Payment extends BaseCommand
{

    function processCommand()
    {
        $this->getBot()->sendMessageWithKeyboard($this->botUser->getId(), $this->translation->get('payment_title'), new InlineKeyboardMarkup([]));
    }

}