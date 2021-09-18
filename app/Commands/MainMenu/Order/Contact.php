<?php

namespace App\Commands\MainMenu\Order;

use App\Commands\BaseCommand;
use App\Models\OrderPhoto;
use App\Models\Order;
use App\Services\Status\UserStatusService;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;
use TelegramBot\Api\Types\InputMedia\ArrayOfInputMedia;
use TelegramBot\Api\Types\InputMedia\InputMediaPhoto;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;
use TelegramBot\Api\Types\ReplyKeyboardRemove;

class Contact extends BaseCommand
{

    function processCommand()
    {
        if ($this->user->status === UserStatusService::ORDER_CONTACT) {
            Order::where('user_id', $this->user->id)->where('status', 'NEW')->update([
                'contact' => $this->update->getMessage()->getText()
            ]);

            $wantCake = Order::where('user_id', $this->user->id)->where('status', 'NEW')->get();

            $this->getBot()->sendMessageWithKeyboard($this->botUser->getId(), $this->translation->get('want_cake_check'), new ReplyKeyboardRemove());

            $cakePhotos = OrderPhoto::where('order_id', $wantCake[0]->id)->get();
            if ($cakePhotos->count()) {
                $media = new ArrayOfInputMedia();
                foreach ($cakePhotos as $cakePhoto) {
                    $media->addItem(new InputMediaPhoto($cakePhoto->file_id));
                }
                $this->getBot()->sendMediaGroup($this->botUser->getId(), $media);
            }

            $this->getBot()->sendMessageWithKeyboard($this->botUser->getId(), '📄 <b>Опис</b>: ' . $wantCake[0]->description . "\n" .
                '📅 <b>Дата:</b> ' . $wantCake[0]->date . "\n" .
                '📞 <b>Контакт:</b> ' . $wantCake[0]->contact . "\n", new InlineKeyboardMarkup([
                [
                    [
                        'text' => $this->translation->get('right'),
                        'callback_data' => json_encode([
                            'a' => 'confirmOrder'
                        ])
                    ]
                ],
                [
                    [
                        'text' => $this->translation->get('false'),
                        'callback_data' => json_encode([
                            'a' => 'cancelCake'
                        ])
                    ]
                ]
            ]), false);
        } else {
            $this->user->status = UserStatusService::ORDER_CONTACT;
            $this->user->save();

            $this->getBot()->sendMessageWithKeyboard($this->botUser->getId(), $this->translation->get('contacts'), new ReplyKeyboardMarkup([
                [$this->translation->get('main_menu')]
            ], false, true));
        }
    }

}