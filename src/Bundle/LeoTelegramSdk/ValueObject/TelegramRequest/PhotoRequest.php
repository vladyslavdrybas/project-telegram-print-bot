<?php

declare(strict_types=1);

namespace App\Bundle\LeoTelegramSdk\ValueObject\TelegramRequest;

class PhotoRequest extends AbstractRequest
{
    protected PhotoCollection $photos;

    public function __construct(
        RequestBase     $messageBase,
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
