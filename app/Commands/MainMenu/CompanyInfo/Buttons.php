<?php

namespace App\Commands\MainMenu\CompanyInfo;

use App\Commands\BaseCommand;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;

class Buttons extends BaseCommand
{

    function processCommand()
    {
        $this->getBot()->sendMessageWithKeyboard($this->botUser->getId(), $this->translation->get('company_info_title'), new InlineKeyboardMarkup([
            [
                [
                    'text' => $this->translation->get('about_us_button'),
                    'callback_data' => json_encode([
                        'a' => 'about_us_b',
                    ])
                ],
            ], [
                [
                    'text' => $this->translation->get('contact_button'),
                    'callback_data' => json_encode([
                        'a' => 'contact_b',
                    ])
                ],
            ], [
                [
                    'text' => $this->translation->get('our_values_button'),
                    'callback_data' => json_encode([
                        'a' => 'our_values_b',
                    ])
                ],
            ]
        ]));
    }

}