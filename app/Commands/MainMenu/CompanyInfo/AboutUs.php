<?php

namespace App\Commands\MainMenu\CompanyInfo;

use App\Commands\BaseCommand;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;

class AboutUs extends BaseCommand
{

    function processCommand()
    {
        $this->getBot()->sendMessageWithKeyboard($this->botUser->getId(), $this->translation->get('about_us_title'), new InlineKeyboardMarkup([
            [[
            'text' => $this->translation->get('back_button'),
            'callback_data' => json_encode([
                'a' => 'info_about_company_b'
            ])
        ]]
        ]));
    }

}