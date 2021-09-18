<?php

namespace App\Commands\MainMenu\WantCake;

use App\Commands\BaseCommand;
use App\Commands\Start;
use App\Models\Order;
use App\Models\WantedCake;
use TelegramBot\Api\Types\ReplyKeyboardRemove;

class Confirm extends BaseCommand
{

    function processCommand()
    {
        $this->getBot()->deleteMessage($this->botUser->getId(), $this->update->getCallbackQuery()->getMessage()->getMessageId());

        $wantCake = WantedCake::where('user_id', $this->user->id)->where('status', 'NEW')->get();
        if ($wantCake[0]->payment_type == $this->translation->get('order_pay_by_card')) {
            WantedCake::where('user_id', $this->user->id)->where('status', 'NEW')->update([
                'status' => 'WAITING_FOR_CHECK'
            ]);

            $this->getBot()->sendMessage($this->botUser->getId(), $this->translation->get('order_we_will_contact_you'));
        }

        $userLink = '<a href="tg://user?id=' . $this->user->chat_id . '">' . $this->user->first_name . '</a>';
        $this->getBot()->sendMessage(env('ADMIN_GROUP_ID'), 'Надійшло нове <b>замовлення</b> №' . intval($wantCake[0]->id + 10000) . ' від ' . $userLink . ':' . "\n" . "\n" .
            '📄 <b>Опис</b>: ' . $wantCake[0]->description . "\n" .
            "😊 <b>Ім'я:</b> " . $wantCake[0]->name . "\n" .
            '📞 <b>Контакт:</b> ' . $wantCake[0]->phone_number . "\n" .
            '🏠 <b>Адрес:</b> ' . $wantCake[0]->address . "\n" .
            '📅 <b>Дата:</b> ' . $wantCake[0]->date . "\n" .
            '💳 <b>Тип оплати:</b> ' . $wantCake[0]->payment_type . "\n", 'html');
        WantedCake::where('user_id', $this->user->id)->where('status', 'NEW')->update([
            'status' => 'DONE'
        ]);

        $this->getBot()->sendMessageWithKeyboard($this->botUser->getId(), $this->translation->get('want_cake_done'), new ReplyKeyboardRemove());
        $this->triggerCommand(Start::class);
    }

}