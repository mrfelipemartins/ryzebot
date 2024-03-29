<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram;

use FondBot\Templates\Attachment;
use FondBot\Drivers\CommandHandler;
use FondBot\Drivers\Commands\SendMessage;
use FondBot\Drivers\Commands\SendRequest;
use FondBot\Drivers\Commands\SendAttachment;

class TelegramCommandHandler extends CommandHandler
{
    /** @var TelegramDriver */
    protected $driver;

    /**
     * Handle send message command.
     *
     * @param SendMessage $command
     */
    protected function handleSendMessage(SendMessage $command): void
    {
        $payload = [
            'chat_id' => $command->getChat()->getId(),
            'text' => $command->getText(),
        ];

        if ($command->getTemplate() !== null) {
            $payload['reply_markup'] = $this->driver->getTemplateCompiler()->compile($command->getTemplate());
        }

        $this->driver->getHttp()->post($this->driver->getBaseUrl().'/sendMessage', ['json' => $payload]);
    }

    /**
     * Handle send attachment command.
     *
     * @param SendAttachment $command
     */
    protected function handleSendAttachment(SendAttachment $command): void
    {
        switch ($command->getAttachment()->getType()) {
            case Attachment::TYPE_IMAGE:
                $type = 'photo';
                $endpoint = 'sendPhoto';
                break;
            case Attachment::TYPE_AUDIO:
                $type = 'audio';
                $endpoint = 'sendAudio';
                break;
            case Attachment::TYPE_VIDEO:
                $type = 'video';
                $endpoint = 'sendVideo';
                break;
            default:
                $type = 'document';
                $endpoint = 'sendDocument';
                break;
        }

        $payload = [
            'multipart' => [
                [
                    'name' => 'chat_id',
                    'contents' => $command->getChat()->getId(),
                ],
                [
                    'name' => $type,
                    'contents' => fopen($command->getAttachment()->getPath(), 'rb'),
                ],
            ],
        ];

        $this->driver->getHttp()->post($this->driver->getBaseUrl().'/'.$endpoint, $payload);
    }

    /**
     * Handle send request command.
     *
     * @param SendRequest $command
     */
    protected function handleSendRequest(SendRequest $command): void
    {
    }
}
