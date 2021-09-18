<?php

namespace App\Commands\MainMenu\Menu;

use App\Commands\BaseCommand;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;
use TelegramBot\Api\Types\InputMedia\ArrayOfInputMedia;
use TelegramBot\Api\Types\InputMedia\InputMediaPhoto;

class Description extends BaseCommand
{

    function processCommand()
    {
        $typeMap = [
            'cake_type' => 'tort',
            'dessert_type' => 'banka',
            'set_type' => 'set',
            'toppings_type' => 'topping',
        ];
        $media = new ArrayOfInputMedia();
        $type = \json_decode($this->update->getCallbackQuery()->getData(), true)['v'];
        $files = scandir(__DIR__ . '/../../../src');
        foreach ($files as $file) {
            if (strpos($file, $typeMap[$type]) !== false) {
                $media->addItem(new InputMediaPhoto('https://ele.kurusa.uno/app/src/' . $file));
            }
        }
        $this->getBot()->sendMediaGroup($this->botUser->getId(), $media);
        $this->getBot()->sendMessageWithKeyboard($this->botUser->getId(), $this->translation->get($type . '_title'), new InlineKeyboardMarkup([
            [[
                'text' => $this->translation->get('back_button'),
                'callback_data' => json_encode([
                    'a' => 'menu_b'
                ])
            ]]
        ]));
    }

}