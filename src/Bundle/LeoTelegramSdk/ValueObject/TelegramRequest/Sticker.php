<?php

declare(strict_types=1);

namespace App\Bundle\LeoTelegramSdk\ValueObject\TelegramRequest;

class Sticker
{
    protected string $fileId;
    protected string $fileUniqueId;
    protected int $width;
    protected int $height;
    protected int $size;
    protected string $emoji;
    protected string $setName;
    protected bool $isAnimated;
    protected bool $isVideo;
    protected Thumb $thumb;

    public function __construct(
        string $fileId,
        string $fileUniqueId,
        int $width,
        int $height,
        int $size,
        string $emoji,
        string $setName,
        bool $isAnimated,
        bool $isVideo,
        Thumb $thumb
    ) {
        $this->fileId = $fileId;
        $this->fileUniqueId = $fileUniqueId;
        $this->width = $width;
        $this->height = $height;
        $this->size = $size;
        $this->emoji = $emoji;
        $this->setName = $setName;
        $this->isAnimated = $isAnimated;
        $this->isVideo = $isVideo;
        $this->thumb = $thumb;
    }

    /**
     * @return string
     */
    public function getFileId(): string
    {
        return $this->fileId;
    }

    /**
     * @return string
     */
    public function getFileUniqueId(): string
    {
        return $this->fileUniqueId;
    }

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @return string
     */
    public function getEmoji(): string
    {
        return $this->emoji;
    }

    /**
     * @return string
     */
    public function getSetName(): string
    {
        return $this->setName;
    }

    /**
     * @return bool
     */
    public function isAnimated(): bool
    {
        return $this->isAnimated;
    }

    /**
     * @return bool
     */
    public function isVideo(): bool
    {
        return $this->isVideo;
    }

    /**
     * @return \App\Bundle\LeoTelegramSdk\ValueObject\TelegramRequest\Thumb
     */
    public function getThumb(): Thumb
    {
        return $this->thumb;
    }
}
