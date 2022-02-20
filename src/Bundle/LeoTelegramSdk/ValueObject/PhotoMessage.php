<?php

declare(strict_types=1);

namespace App\Bundle\LeoTelegramSdk\ValueObject;

use JetBrains\PhpStorm\Immutable;

#[Immutable]
class PhotoMessage extends AbstractMessage
{
    /**
     * @var PhotoCollection
     */
    protected PhotoCollection $photos;

    public function __construct(
        MessageBase $messageBase,
        PhotoCollection $photos
    ) {
        parent::__construct($messageBase);
        $this->photos = $photos;
    }

    /**
     * @return PhotoCollection
     */
    public function getPhotos(): PhotoCollection
    {
        return $this->photos;
    }
}
