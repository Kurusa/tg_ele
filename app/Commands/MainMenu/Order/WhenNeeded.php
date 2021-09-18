<?php

namespace App\Commands\MainMenu\Order;

use App\Commands\BaseCommand;
use App\Models\Order;
use App\Services\Status\UserStatusService;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;

class WhenNeeded extends BaseCommand
{

    function processCommand()
    {
        if ($this->user->status === UserStatusService::ORDER_DATE) {
            if ($this->update->getMessage()) {
                Order::where('user_id', $this->user->id)->where('status', 'NEW')->update([
                    'date' => $this->update->getMessage()->getText()
                ]);
                $this->triggerCommand(PaymentType::class);
            }
        } else {
            if ($this->user->status == UserStatusService::CAKE_PHOTO) {
                $this->triggerCommand(\App\Commands\MainMenu\WantCake\Name::class);
                exit();
            }
            $this->user->status = UserStatusService::ORDER_DATE;
            $this->user->save();

            $this->getBot()->sendMessageWithKeyboard($this->botUser->getId(), $this->translation->get('when_needed'), new ReplyKeyboardMarkup([
                [$this->translation->get('main_menu')]
            ], false, true));
        }
    }

}