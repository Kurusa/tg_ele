<?php

namespace App\Commands\MainMenu\Menu;

use App\Commands\BaseCommand;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;

class Types extends BaseCommand
{

    function processCommand()
    {
        $buttons = [];
        foreach ($this->translation->getMenuTypes() as $menuType) {
            $buttons[] = [[
                'text' => $menuType->value,
                'callback_data' => json_encode([
                    'a' => 'menuType',
                    'v' => $menuType->key,
                ])
            ],];
        }

        $this->getBot()->sendMessageWithKeyboard($this->botUser->getId(), $this->translation->get('menu_title'), new InlineKeyboardMarkup($buttons));
    }

}