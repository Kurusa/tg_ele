<?php

namespace App\Commands\MainMenu\Order;

use App\Commands\BaseCommand;
use App\Models\OrderPhoto;
use App\Models\Order;
use App\Services\Status\UserStatusService;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;

class Photo extends BaseCommand
{

    function processCommand()
    {
        if ($this->user->status === UserStatusService::ORDER_PHOTO) {
            if ($this->update->getMessage()->getPhoto()) {
                OrderPhoto::create([
                    'order_id' => Order::where('user_id', $this->user->id)->where('status', 'NEW')->get()[0]->id,
                    'file_id' => $this->update->getMessage()->getPhoto()[0]->getFileId()
                ]);

                $this->triggerCommand(WhenNeeded::class);
            }
        } else {
            $this->user->status = UserStatusService::ORDER_PHOTO;
            $this->user->save();

            $this->getBot()->sendMessageWithKeyboard($this->botUser->getId(), $this->translation->get('load_photo_example'), new ReplyKeyboardMarkup([
                [$this->translation->get('main_menu')],
                [$this->translation->get('next_for_order')]
            ], false, true));
        }
    }

}