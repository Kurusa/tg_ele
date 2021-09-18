<?php

namespace App\Commands;

use App\Services\Status\UserStatusService;
use CURLFile;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;
use TelegramBot\Api\Types\ReplyKeyboardRemove;

class Start extends BaseCommand
{

    function processCommand()
    {
        $this->user->status = UserStatusService::DONE;
        $this->user->save();

        $mainMenuButtons = new InlineKeyboardMarkup([
            [
                [
                    'text' => $this->translation->get('info_about_company_button'),
                    'callback_data' => json_encode([
                        'a' => 'info_about_company_b',
                    ])
                ],
                [
                    'text' => $this->translation->get('feedback_button'),
                    'callback_data' => json_encode([
                        'a' => 'feedback_b',
                    ])
                ],
            ], [
                [
                    'text' => $this->translation->get('menu_button'),
                    'callback_data' => json_encode([
                        'a' => 'menu_b',
                    ])
                ],
                [
                    'text' => $this->translation->get('order_button'),
                    'callback_data' => json_encode([
                        'a' => 'order_b',
                    ])
                ],
            ], [
                [
                    'text' => $this->translation->get('want_my_cake_button'),
                    'callback_data' => json_encode([
                        'a' => 'want_my_cake_b',
                    ])
                ],
                [
                    'text' => $this->translation->get('ads_button'),
                    'callback_data' => json_encode([
                        'a' => 'ads_b',
                    ])
                ],
            ], [
                [
                    'text' => $this->translation->get('socials_button'),
                    'callback_data' => json_encode([
                        'a' => 'socials_b',
                    ])
                ],
                [
                    'text' => $this->translation->get('payment_button'),
                    'callback_data' => json_encode([
                        'a' => 'payment_b',
                    ])
                ],
            ],
        ]);

        $this->getBot()->sendPhoto($this->botUser->getId(), new CurlFile('https://ele.kurusa.uno/app/src/start.jpg'), null, null, new ReplyKeyboardRemove());
        $this->getBot()->sendMessageWithKeyboard($this->botUser->getId(), $this->translation->get('start_message'), $mainMenuButtons, false);
    }

}
