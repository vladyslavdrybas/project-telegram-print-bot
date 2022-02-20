<?php

declare(strict_types=1);

namespace App\Bundle\LeoTelegramSdk\ValueObject;

use DateTimeImmutable;

abstract class AbstractMessage implements MessageInterface
{
    protected int $updateId;
    protected int $messageId;
    protected DateTimeImmutable $date;
    protected From $from;
    protected Chat $chat;
    protected Metadata $metadata;

    /**
     * @param \App\Bundle\LeoTelegramSdk\ValueObject\MessageBase $messageBase
     */
    public function __construct(MessageBase $messageBase)
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
     * @return \App\Bundle\LeoTelegramSdk\ValueObject\From
     */
    public function getFrom(): From
    {
        return $this->from;
    }

    /**
     * @return \App\Bundle\LeoTelegramSdk\ValueObject\Chat
     */
    public function getChat(): Chat
    {
        return $this->chat;
    }

    /**
     * @return \App\Bundle\LeoTelegramSdk\ValueObject\Metadata
     */
    public function getMetadata(): Metadata
    {
        return $this->metadata;
    }
}
