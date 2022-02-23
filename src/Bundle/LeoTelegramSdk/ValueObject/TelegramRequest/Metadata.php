<?php

declare(strict_types=1);

namespace App\Bundle\LeoTelegramSdk\ValueObject\TelegramRequest;

use function time;

class Metadata
{
    public const PHOTO_MESSAGE_TYPE = 'PhotoRequest';
    public const COMMAND_MESSAGE_TYPE = 'CommandRequest';
    public const TEXT_MESSAGE_TYPE = 'TextRequest';
    public const BASE_MESSAGE_TYPE = 'BaseMessage';
    public const STICKER_MESSAGE_TYPE = 'StickerRequest';

    protected string $class;
    protected string $type;
    protected int $receivedAt;

    protected bool $isPhotoMessage = false;
    protected bool $isCommandMessage = false;
    protected bool $isTextMessage = false;
    protected bool $isSkeletonMessage = false;

    public function __construct(
        string $class,
        string $type
    ) {
        $this->class = $class;
        $this->type = $type;
        $this->{'is' . $type} = true;
        $this->receivedAt = time();
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * @return int
     */
    public function getReceivedAt(): int
    {
        return $this->receivedAt;
    }

    /**
     * @return bool
     */
    public function isPhotoMessage(): bool
    {
        return $this->isPhotoMessage;
    }

    /**
     * @return bool
     */
    public function isCommandMessage(): bool
    {
        return $this->isCommandMessage;
    }

    /**
     * @return bool
     */
    public function isTextMessage(): bool
    {
        return $this->isTextMessage;
    }

    /**
     * @return bool
     */
    public function isSkeletonMessage(): bool
    {
        return $this->isSkeletonMessage;
    }
}