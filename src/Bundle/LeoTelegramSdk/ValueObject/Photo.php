<?php

declare(strict_types=1);

namespace App\Bundle\LeoTelegramSdk\ValueObject;

use JetBrains\PhpStorm\Immutable;

#[Immutable]
class Photo
{
    protected string $fileId;
    protected string $fileUniqueId;
    protected int $width;
    protected int $height;
    protected string $caption = '';

    public function __construct(
        string $fileId,
        string $fileUniqueId,
        int $width,
        int $height,
        string $caption
    ) {
        $this->fileId = $fileId;
        $this->fileUniqueId = $fileUniqueId;
        $this->width = $width;
        $this->height = $height;
        $this->caption = $caption;
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
     * @return string
     */
    public function getCaption(): string
    {
        return $this->caption;
    }
}
