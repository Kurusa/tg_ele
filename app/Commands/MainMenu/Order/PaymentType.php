<?php

namespace App\Commands\MainMenu\Order;

use App\Commands\BaseCommand;
use App\Models\Order;
use App\Services\Status\UserStatusService;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;
use TelegramBot\Api\Types\ReplyKeyboardRemove;

class PaymentType extends BaseCommand
{

    function processCommand()
    {
        if ($this->user->status === UserStatusService::ORDER_PAYMENT_TYPE) {
            Order::where('user_id', $this->user->id)->where('status', 'NEW')->update([
                'payment_type' => $this->update->getMessage()->getText()
            ]);

            $wantCake = Order::where('user_id', $this->user->id)->where('status', 'NEW')->get();

            $this->getBot()->sendMessageWithKeyboard($this->botUser->getId(), $this->translation->get('want_cake_check'), new ReplyKeyboardRemove());
            $this->getBot()->sendMessageWithKeyboard($this->botUser->getId(), '📄 <b>Опис</b>: ' . $wantCake[0]->description . "\n" .
                "😊 <b>Ім'я:</b> " . $wantCake[0]->name . "\n" .
                '📞 <b>Контакт:</b> ' . $wantCake[0]->phone_number . "\n" .
                '🏠 <b>Адрес:</b> ' . $wantCake[0]->address . "\n" .
                '📅 <b>Дата:</b> ' . $wantCake[0]->date . "\n" .
                '💳 <b>Тип оплати:</b> ' . $wantCake[0]->payment_type . "\n", new InlineKeyboardMarkup([
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
            $this->user->status = UserStatusService::ORDER_PAYMENT_TYPE;
            $this->user->save();

            $this->getBot()->sendMessageWithKeyboard($this->botUser->getId(), $this->translation->get('order_select_payment_type'), new ReplyKeyboardMarkup([
                [$this->translation->get('order_pay_by_card')],
                [$this->translation->get('order_pay_in_the_shop')],
                [$this->translation->get('main_menu')]
            ], false, true));
        }
    }

}