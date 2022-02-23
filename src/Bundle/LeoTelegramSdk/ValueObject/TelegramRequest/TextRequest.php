<?php

declare(strict_types=1);

namespace App\Bundle\LeoTelegramSdk\ValueObject\TelegramRequest;

use JetBrains\PhpStorm\Immutable;

#[Immutable]
class TextRequest extends AbstractRequest
{
    protected string $text = '';

    public function __construct(
        RequestBase $messageBase,
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
