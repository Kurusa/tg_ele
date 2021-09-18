<?php

namespace App\Commands\MainMenu\Feedback;

use App\Commands\BaseCommand;
use App\Commands\Start;
use App\Models\Feedback;
use App\Services\Status\UserStatusService;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;
use TelegramBot\Api\Types\ReplyKeyboardRemove;

class HaveProposal extends BaseCommand
{

    function processCommand()
    {
        if ($this->user->status === UserStatusService::HAVE_PROPOSAL) {
            if ($this->update->getMessage()) {
                Feedback::create([
                    'user_id' => $this->user->id,
                    'text' => $this->update->getMessage()->getText(),
                    'type' => 'proposal'
                ]);

                $userLink = '<a href="tg://user?id=' . $this->user->chat_id . '">' . $this->user->first_name . '</a>';
                $this->getBot()->sendMessage(env('ADMIN_GROUP_ID'), 'Поступила нова <b>пропозиція</b> від ' . $userLink . ':' . "\n" . "\n" . $this->update->getMessage()->getText(), 'html');

                $this->getBot()->sendMessageWithKeyboard($this->botUser->getId(), $this->translation->get('thank_you'), new ReplyKeyboardRemove());
                $this->triggerCommand(Start::class);
            }
        } else {
            $this->user->status = UserStatusService::HAVE_PROPOSAL;
            $this->user->save();

            $this->getBot()->sendMessageWithKeyboard($this->botUser->getId(), $this->translation->get('write_proposal'), new ReplyKeyboardMarkup([
                [$this->translation->get('main_menu')]
            ], false, true));
        }
    }

}