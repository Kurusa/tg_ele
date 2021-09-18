<?php

namespace App\Utils;

use App\Services\Translation;
use TelegramBot\Api\{Exception,
    InvalidArgumentException,
    Types\Inline\InlineKeyboardMarkup,
    Types\Message,
    BotApi
};

class Api extends BotApi
{

    /**
     * @var Translation
     */
    private $translationService;

    public function __construct($token, $trackerToken = null)
    {
        parent::__construct($token, $trackerToken);
    }

    /**
     * @param int $chatId
     * @param string $text
     * @param $keyboard
     * @param bool $addMainMenu
     * @return Message
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function sendMessageWithKeyboard(int $chatId, string $text, $keyboard, $addMainMenu = true): Message
    {
        if ($keyboard instanceof InlineKeyboardMarkup && $addMainMenu) {
            $editedKeyboard = $keyboard->getInlineKeyboard();
            $editedKeyboard[] = [
                [
                    'text' => $this->translationService->get('main_menu'),
                    'callback_data' => json_encode([
                        'a' => 'main_menu',
                    ])
                ],
            ];
            $keyboard->setInlineKeyboard($editedKeyboard);
        }
        return $this->sendMessage($chatId, $text, 'HTML', true, null, $keyboard);
    }

    /**
     * @param Translation $translation
     */
    public function setTranslationService(Translation $translation)
    {
        $this->translationService = $translation;
    }

}