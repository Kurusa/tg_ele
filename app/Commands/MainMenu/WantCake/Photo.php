<?php

namespace App\Commands\MainMenu\WantCake;

use App\Commands\BaseCommand;
use App\Models\WantCakePhoto;
use App\Models\WantedCake;
use App\Services\Status\UserStatusService;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;

class Photo extends BaseCommand
{

    function processCommand()
    {
        if ($this->user->status === UserStatusService::CAKE_PHOTO) {
            if ($this->update->getMessage()->getPhoto()) {
                WantCakePhoto::create([
                    'want_cake_id' => WantedCake::where('user_id', $this->user->id)->where('status', 'NEW')->get()[0]->id,
                    'file_id' => $this->update->getMessage()->getPhoto()[0]->getFileId()
                ]);

                $this->triggerCommand(Name::class);
            }
        } else {
            $this->user->status = UserStatusService::CAKE_PHOTO;
            $this->user->save();

            $this->getBot()->sendMessageWithKeyboard($this->botUser->getId(), $this->translation->get('load_photo_example'), new ReplyKeyboardMarkup([
                [$this->translation->get('main_menu')],
                [$this->translation->get('next')]
            ], false, true));
        }
    }

}