<?php

namespace App\Commands\MainMenu;

use App\Commands\BaseCommand;

class AboutUs extends BaseCommand
{

    function processCommand()
    {
        $this->getBot()->sendMessage($this->user->chat_id, 'about us');
    }

}