<?php

declare(strict_types=1);

namespace App\Bundle\LeoTelegramSdk\ValueObject\TelegramRequest;

use DateTimeImmutable;

class RequestBase implements RequestInterface
{
    protected int $updateId;
    protected int $messageId;
    protected DateTimeImmutable $date;
    protected From $from;
    protected Chat $chat;
    protected Metadata $metadata;

    public function __construct(
        int               $updateId,
        int               $messageId,
        DateTimeImmutable $date,
        From              $from,
        Chat              $chat,
        Metadata          $metadata
    ) {
        $this->updateId = $updateId;
        $this->messageId = $messageId;
        $this->date = $date;
        $this->from = $from;
        $this->chat = $chat;
        $this->metadata = $metadata;
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
