<?php

declare(strict_types=1);

namespace App\Bundle\LeoTelegramSdk\ValueObject;

class StickerMessage extends AbstractMessage
{
    protected Sticker $sticker;

    public function __construct(
        MessageBase $messageBase,
        Sticker $sticker
    ) {
        parent::__construct($messageBase);
        $this->sticker = $sticker;
    }

    /**
     * @return \App\Bundle\LeoTelegramSdk\ValueObject\Sticker
     */
    public function getSticker(): Sticker
    {
        return $this->sticker;
    }
}
