<?php

namespace App\Commands\MainMenu;

use App\Commands\BaseCommand;

class Contact extends BaseCommand
{

    function processCommand()
    {
        $this->getBot()->sendMessage($this->user->chat_id, 'contact');
    }

}