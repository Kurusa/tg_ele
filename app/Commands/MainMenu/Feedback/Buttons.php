<?php

namespace App\Commands\MainMenu\Feedback;

use App\Commands\BaseCommand;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;

class Buttons extends BaseCommand
{

    function processCommand()
    {
        $this->getBot()->sendMessageWithKeyboard($this->botUser->getId(), $this->translation->get('feedback_title'), new InlineKeyboardMarkup([
            [
                [
                    'text' => $this->translation->get('leave_review_button'),
                    'callback_data' => json_encode([
                        'a' => 'leave_review_b',
                    ])
                ],
                [
                    'text' => $this->translation->get('have_proposal_button'),
                    'callback_data' => json_encode([
                        'a' => 'have_proposal_b',
                    ])
                ],
            ],
        ]));
    }

}