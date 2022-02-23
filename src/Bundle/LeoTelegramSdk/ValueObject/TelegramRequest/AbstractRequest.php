<?php

declare(strict_types=1);

namespace App\Bundle\LeoTelegramSdk\ValueObject\TelegramRequest;

use DateTimeImmutable;

abstract class AbstractRequest implements RequestInterface
{
    protected int $updateId;
    protected int $messageId;
    protected DateTimeImmutable $date;
    protected From $from;
    protected Chat $chat;
    protected Metadata $metadata;

    /**
     * @param \App\Bundle\LeoTelegramSdk\ValueObject\TelegramRequest\RequestBase $messageBase
     */
    public function __construct(RequestBase $messageBase)
    {
        $this->updateId = $messageBase->getUpdateId();
        $this->messageId = $messageBase->getMessageId();
        $this->date = $messageBase->getDate();
        $this->from = $messageBase->getFrom();
        $this->chat = $messageBase->getChat();
        $this->metadata = $messageBase->getMetadata();
    }

    /**
     * @return int
     */
    public function getUpdateId(): int
    {
        return $this->updateId;
    }

    /**
     * @return int
     */
    public function getMessageId(): int
    {
        return $this->messageId;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    /**
     * @return \App\Bundle\LeoTelegramSdk\ValueObject\TelegramRequest\From
     */
    public function getFrom(): From
    {
        return $this->from;
    }

    /**
     * @return \App\Bundle\LeoTelegramSdk\ValueObject\TelegramRequest\Chat
     */
    public function getChat(): Chat
    {
        return $this->chat;
    }

    /**
     * @return \App\Bundle\LeoTelegramSdk\ValueObject\TelegramRequest\Metadata
     */
    public function getMetadata(): Metadata
    {
        return $this->metadata;
    }
}
