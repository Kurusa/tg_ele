<?php

namespace App\Commands\MainMenu;

use App\Commands\BaseCommand;
use App\Models\Ad;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;

class Ads extends BaseCommand
{

    function processCommand()
    {
        if (Ad::all()->count()) {
            foreach (Ad::all() as $ad) {
                if ($ad->image) {
                    $this->getBot()->sendPhoto($this->botUser->getId(), new \CURLFile('https://ele.kurusa.uno/app/src/' . $ad->image));
                }
                $this->getBot()->sendMessageWithKeyboard($this->botUser->getId(), $ad->description, new InlineKeyboardMarkup([]));
            }
        } else {
            $this->getBot()->sendMessage($this->botUser->getId(), $this->translation->get('no_ads'), null, false, $this->update->getCallbackQuery()->getMessage()->getMessageId());
        }
    }

}