<?php

declare(strict_types=1);

namespace App\Bundle\LeoTelegramSdk\Message;

abstract class AbstractMessage implements MessageInterface
{
    protected string $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
