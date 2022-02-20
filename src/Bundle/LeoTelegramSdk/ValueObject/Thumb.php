<?php

declare(strict_types=1);

namespace App\Bundle\LeoTelegramSdk\ValueObject;

class Thumb
{
    protected string $fileId;
    protected string $fileUniqueId;
    protected int $width;
    protected int $height;
    protected int $size;

    public function __construct(
        string $fileId,
        string $fileUniqueId,
        int $width,
        int $height,
        int $size
    ) {
        $this->fileId = $fileId;
        $this->fileUniqueId = $fileUniqueId;
        $this->width = $width;
        $this->height = $height;
        $this->size = $size;
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
}
