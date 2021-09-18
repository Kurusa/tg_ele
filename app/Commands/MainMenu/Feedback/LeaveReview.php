<?php

namespace App\Commands\MainMenu\Feedback;

use App\Commands\BaseCommand;
use App\Commands\Start;
use App\Models\Feedback;
use App\Services\Status\UserStatusService;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;
use TelegramBot\Api\Types\ReplyKeyboardRemove;

class LeaveReview extends BaseCommand
{

    function processCommand()
    {
        if ($this->user->status === UserStatusService::LEAVE_REVIEW) {
            if ($this->update->getMessage()) {
                Feedback::create([
                    'user_id' => $this->user->id,
                    'text' => $this->update->getMessage()->getText(),
                    'type' => 'review'
                ]);

                $userLink = '<a href="tg://user?id=' . $this->user->chat_id . '">' . $this->user->first_name . '</a>';
                $this->getBot()->sendMessage(env('ADMIN_GROUP_ID'), 'Поступив новий <b>відгук</b> від ' . $userLink . ':' . "\n" . "\n" . $this->update->getMessage()->getText(), 'html');


                $this->getBot()->sendMessageWithKeyboard($this->botUser->getId(), $this->translation->get('thank_you'), new ReplyKeyboardRemove());
                $this->triggerCommand(Start::class);
            }
        } else {
            $this->user->status = UserStatusService::LEAVE_REVIEW;
            $this->user->save();

            $this->getBot()->sendMessageWithKeyboard($this->botUser->getId(), $this->translation->get('write_review'), new ReplyKeyboardMarkup([
                [$this->translation->get('main_menu')]
            ], false, true));
        }
    }

}