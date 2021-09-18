<?php

namespace App\Commands\MainMenu;

use App\Commands\BaseCommand;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;

class Socials extends BaseCommand
{

    function processCommand()
    {
        $buttons = new InlineKeyboardMarkup([
            [
                [
                    'text' => $this->translation->get('facebook_button'),
                    'url' => $this->translation->get('facebook_link')
                ],
                [
                    'text' => $this->translation->get('instagram_button'),
                    'url' => $this->translation->get('instagram_link')
                ],
            ]
        ]);
        $this->getBot()->sendMessageWithKeyboard($this->botUser->getId(), $this->translation->get('socials_title'), $buttons);
    }

}