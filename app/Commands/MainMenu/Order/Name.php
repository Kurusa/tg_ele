<?php

namespace App\Commands\MainMenu\Order;

use App\Commands\BaseCommand;
use App\Models\Order;
use App\Services\Status\UserStatusService;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;

class Name extends BaseCommand
{

    function processCommand()
    {
        if ($this->user->status === UserStatusService::ORDER_NAME) {
            if ($this->update->getMessage()->getContact()) {
                Order::where('user_id', $this->user->id)->where('status', 'NEW')->update([
                    'name' => $this->update->getMessage()->getContact()->getFirstName() . ' ' . $this->update->getMessage()->getContact()->getLastName(),
                    'phone_number' => $this->update->getMessage()->getContact()->getPhoneNumber(),
                ]);
                // skip phone number question
                $this->triggerCommand(Address::class);
            } else {
                Order::where('user_id', $this->user->id)->where('status', 'NEW')->update([
                    'name' => $this->update->getMessage()->getText(),
                ]);
                $this->triggerCommand(PhoneNumber::class);
            }

        } else {
            $this->user->status = UserStatusService::ORDER_NAME;
            $this->user->save();

            $this->getBot()->sendMessageWithKeyboard($this->user->chat_id, $this->translation->get('order_ask_name'), new ReplyKeyboardMarkup([
                [['text' => $this->translation->get('order_share_contact'), 'request_contact' => true]],
                [$this->translation->get('main_menu')]
            ], false, true));
        }
    }

}