<?php

declare(strict_types=1);

namespace App\Bundle\LeoTelegramSdk\ValueObject\TelegramRequest;

use function time;

class Metadata
{
    public const BASE_REQUEST_TYPE = 'BaseRequest';
    public const COMMAND_REQUEST_TYPE = 'CommandRequest';
    public const TEXT_REQUEST_TYPE = 'TextRequest';
    public const STICKER_REQUEST_TYPE = 'StickerRequest';
    public const PHOTO_REQUEST_TYPE = 'PhotoRequest';
    public const DOCUMENT_REQUEST_TYPE = 'DocumentRequest';

    protected string $class;
    protected string $type;
    protected int $receivedAt;

    protected bool $isBaseRequest = false;
    protected bool $isCommandRequest = false;
    protected bool $isTextRequest = false;
    protected bool $isStickerRequest = false;
    protected bool $isPhotoRequest = false;
    protected bool $isDocumentRequest = false;

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
    public function isBaseRequest(): bool
    {
        return $this->isBaseRequest;
    }

    /**
     * @return bool
     */
    public function isCommandRequest(): bool
    {
        return $this->isCommandRequest;
    }

    /**
     * @return bool
     */
    public function isTextRequest(): bool
    {
        return $this->isTextRequest;
    }

    /**
     * @return bool
     */
    public function isStickerRequest(): bool
    {
        return $this->isStickerRequest;
    }

    /**
     * @return bool
     */
    public function isPhotoRequest(): bool
    {
        return $this->isPhotoRequest;
    }

    /**
     * @return bool
     */
    public function isDocumentRequest(): bool
    {
        return $this->isDocumentRequest;
    }
}
