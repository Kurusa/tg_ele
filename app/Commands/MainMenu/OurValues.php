<?php

namespace App\Commands\MainMenu;

use App\Commands\BaseCommand;

class OurValues extends BaseCommand
{

    function processCommand()
    {
        $this->getBot()->sendMessage($this->user->chat_id, 'our values');
    }

}