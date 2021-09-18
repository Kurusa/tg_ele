<?php

namespace App\Commands;

use App\Services\Translation;
use App\Utils\Api;
use App\Models\BotUser;
use TelegramBot\Api\{BotApi, Types\Update, Types\User as TelegramBotUser};
use Exception;

/**
 * Class BaseCommand
 * @package App\Commands
 */
abstract class BaseCommand
{
    /**
     * @var BotApi $bot
     */
    private $bot;

    /**
     * @var BotUser
     */
    protected $user;

    /**
     * @var TelegramBotUser $user
     */
    protected $botUser;

    /**
     * @var Update
     */
    protected $update;

    /**
     * @var Translation
     */
    protected $translation;

    /**
     * BaseCommand constructor.
     * @param Translation $translation
     */
    public function __construct(Translation $translation)
    {
        $this->translation = $translation;
    }

    public function handle($update)
    {
        $this->update = $update;

        $this->user = BotUser::firstOrCreate([
            'chat_id' => $this->getBotUser()->getId()
        ], [
            'user_name' => $this->getBotUser()->getUsername(),
            'first_name' => $this->getBotUser()->getFirstName(),
        ]);

        $this->processCommand();
    }

    /**
     * @return TelegramBotUser
     * @throws Exception
     */
    public function getBotUser(): TelegramBotUser
    {
        if (!$this->botUser) {
            if ($this->update->getCallbackQuery()) {
                $this->botUser = $this->update->getCallbackQuery()->getFrom();
                //$this->getBot()->answerCallbackQuery($this->update->getCallbackQuery()->getId());
            } elseif ($this->update->getMessage()) {
                $this->botUser = $this->update->getMessage()->getFrom();
            } else {
                throw new Exception('cant get telegram user data');
            }
        }

        return $this->botUser;
    }

    /**
     * @return Api
     */
    public function getBot(): Api
    {
        if (!$this->bot) {
            $this->bot = new Api(env('TELEGRAM_BOT_TOKEN'));
            $this->bot->setTranslationService($this->translation);
        }

        return $this->bot;
    }

    /**
     * @param $class
     */
    public function triggerCommand($class)
    {
        (new $class($this->translation))->handle($this->update);
    }

    abstract function processCommand();

}