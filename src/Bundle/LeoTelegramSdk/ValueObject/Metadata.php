<?php

declare(strict_types=1);

namespace App\Bundle\LeoTelegramSdk\ValueObject;

use JetBrains\PhpStorm\Immutable;

#[Immutable]
class Metadata
{
    public const PHOTO_MESSAGE_TYPE = 'PhotoMessage';
    public const COMMAND_MESSAGE_TYPE = 'CommandMessage';
    public const TEXT_MESSAGE_TYPE = 'TextMessage';
    public const SKELETON_MESSAGE_TYPE = 'SkeletonMessage';

    protected string $sdkMessageValueObjectClass;
    protected string $type;

    protected bool $isPhotoMessage = false;
    protected bool $isCommandMessage = false;
    protected bool $isTextMessage = false;
    protected bool $isSkeletonMessage = false;

    public function __construct(
        string $sdkMessageValueObjectClass,
        string $type
    ) {
        $this->sdkMessageValueObjectClass = $sdkMessageValueObjectClass;
        $this->type = $type;
        $this->{'is' . $type} = true;
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
    public function getSdkMessageValueObjectClass(): string
    {
        return $this->sdkMessageValueObjectClass;
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
