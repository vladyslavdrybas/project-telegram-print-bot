<?php

declare(strict_types=1);

namespace App\Bundle\LeoTelegramSdk\Message;

interface MessageInterface
{
    public function getMessage(): string;
}
