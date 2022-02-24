<?php

declare(strict_types=1);

namespace App\Bundle\LeoTelegramSdk\ValueObject\TelegramRequest;

class Document
{
    protected string $fileId;
    protected string $fileUniqueId;
    protected int $size;
    protected string $fileName;
    protected string $mimeType;
    protected string $caption;
    protected Thumb $thumb;

    public function __construct(
        string $fileId,
        string $fileUniqueId,
        int $size,
        string $fileName,
        string $mimeType,
        string $caption,
        Thumb $thumb
    ) {
        $this->fileId = $fileId;
        $this->fileUniqueId = $fileUniqueId;
        $this->size = $size;
        $this->fileName = $fileName;
        $this->mimeType = $mimeType;
        $this->caption = $caption;
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
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }

    /**
     * @return string
     */
    public function getMimeType(): string
    {
        return $this->mimeType;
    }

    /**
     * @return \App\Bundle\LeoTelegramSdk\ValueObject\TelegramRequest\Thumb
     */
    public function getThumb(): Thumb
    {
        return $this->thumb;
    }

    /**
     * @return string
     */
    public function getCaption(): string
    {
        return $this->caption;
    }
}
