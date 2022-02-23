<?php

declare(strict_types=1);

namespace App\Bundle\LeoTelegramSdk\ValueObject\TelegramRequest;

class StickerRequest extends AbstractRequest
{
    protected Sticker $sticker;

    public function __construct(
        RequestBase $messageBase,
        Sticker     $sticker
    ) {
        parent::__construct($messageBase);
        $this->sticker = $sticker;
    }

    /**
     * @return \App\Bundle\LeoTelegramSdk\ValueObject\TelegramRequest\Sticker
     */
    public function getSticker(): Sticker
    {
        return $this->sticker;
    }
}
