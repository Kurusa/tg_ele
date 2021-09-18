<?php

namespace App\Commands\MainMenu;

use App\Commands\BaseCommand;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;

class CompanyInfoButtons extends BaseCommand
{

    function processCommand()
    {
        $this->getBot()->editMessageText($this->user->chat_id, $this->update->getCallbackQuery()->getMessage()->getMessageId(),'Выберите что вам интересно', null, false, new InlineKeyboardMarkup([
            [
                [
                    'text' => 'О Кондитерской',
                    'callback_data' => json_encode([
                        'a' => 'about_us_b',
                    ])
                ],
            ], [
                [
                    'text' => 'Контакты',
                    'callback_data' => json_encode([
                        'a' => 'contact_b',
                    ])
                ],
            ], [
                [
                    'text' => 'Наши ценности',
                    'callback_data' => json_encode([
                        'a' => 'our_values_b',
                    ])
                ],
            ], [
                [
                    'text' => 'Назад',
                    'callback_data' => json_encode([
                        'a' => 'back_b',
                    ])
                ],
            ],
        ]));
    }

}