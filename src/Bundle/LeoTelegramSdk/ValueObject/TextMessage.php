<?php

declare(strict_types=1);

namespace App\Bundle\LeoTelegramSdk\ValueObject;

use JetBrains\PhpStorm\Immutable;

#[Immutable]
class TextMessage extends AbstractMessage
{
    protected string $text = '';

    public function __construct(
        MessageBase $messageBase,
        string      $text
    ) {
        parent::__construct($messageBase);
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }
}
