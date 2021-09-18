<?php

namespace App\Commands\MainMenu\CompanyInfo;

use App\Commands\BaseCommand;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;

class Contact extends BaseCommand
{

    function processCommand()
    {
        $this->getBot()->sendMessageWithKeyboard($this->botUser->getId(), $this->translation->get('contact_title'), new InlineKeyboardMarkup([ [[
            'text' => $this->translation->get('back_button'),
            'callback_data' => json_encode([
                'a' => 'info_about_company_b'
            ])
        ]]]));
    }

}