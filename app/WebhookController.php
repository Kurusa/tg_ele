<?php

namespace App;

use App\Commands\MainMenu\Order\Name;
use App\Commands\MainMenu\WantCake\Photo;
use App\Commands\Start;
use App\Models\BotUser;
use App\Services\Status\UserStatusService;
use TelegramBot\Api\{Client, InvalidJsonException, Types\Update};
use DI\Container;

class WebhookController
{

    protected $handlerClassName = false;

    public function handle()
    {
        $client = new Client(getenv('TELEGRAM_BOT_TOKEN'));
        $container = new Container();

        $client->on(function (Update $update) use ($container) {

            if ($update->getCallbackQuery()) {
                $this->processCallbackCommand($update);
            } elseif ($update->getMessage()) {
                $text = $update->getMessage()->getText();

                if ($text) {
                    $this->processSlashCommand($text);
                    $this->processKeyboardCommand($text);
                    $this->processStatusCommand($update);
                } elseif ($update->getMessage()->getPhoto()) {
                    $this->handlerClassName = Photo::class;
                } elseif ($update->getMessage()->getContact()) {
                    $user = BotUser::where('chat_id', $update->getMessage()->getFrom()->getId())->first();
                    if ($user->status == UserStatusService::ORDER_NAME) {
                        $this->handlerClassName = Name::class;
                    } elseif ($user->status == UserStatusService::CAKE_NAME) {
                        $this->handlerClassName = \App\Commands\MainMenu\WantCake\Name::class;
                    }
                }
            }

            $this->checkHandlerClassName();

            $container->get($this->handlerClassName)->handle($update);
        }, function (Update $update) {
            return true;
        });

        try {
            $client->run();
        } catch (InvalidJsonException $ex) {
        }
    }

    public function checkHandlerClassName()
    {
        if (!$this->handlerClassName) {
            $this->handlerClassName = Start::class;
        }
    }

    /**
     * @param $update
     */
    public function processCallbackCommand($update)
    {
        $config = include_once(__DIR__ . '/config/callback_commands.php');
        $action = \json_decode($update->getCallbackQuery()->getData(), true)['a'];

        if (isset($config[$action])) {
            $this->handlerClassName = $config[$action];
        }
    }

    /**
     * @param $text
     */
    public function processSlashCommand(string $text)
    {
        if (str_starts_with($text, '/')) {
            $handlers = include_once(__DIR__ . '/config/slash_commands.php');
            // cut possible command params
            $command = explode(' ', $text)[0];
            if (isset($command)) {
                $this->handlerClassName = $handlers[$command];
            }
        }
    }

    /**
     * @param $text
     */
    public function processKeyboardCommand(string $text)
    {
        if (!$this->handlerClassName) {
            $handlers = include_once(__DIR__ . '/config/keyboard_commands.php');
            if (isset($handlers[$text])) {
                $this->handlerClassName = $handlers[$text];
            }
        }
    }

    /**
     * @param $update
     */
    public function processStatusCommand($update)
    {
        if (!$this->handlerClassName) {
            $handlers = include_once(__DIR__ . '/config/status_commands.php');
            $user = BotUser::where('chat_id', $update->getMessage()->getFrom()->getId())->first();
            if (isset($handlers[$user->status])) {
                $this->handlerClassName = $handlers[$user->status];
            }
        }
    }

}