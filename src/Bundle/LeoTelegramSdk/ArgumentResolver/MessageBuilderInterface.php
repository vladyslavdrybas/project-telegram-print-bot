<?php

declare(strict_types=1);

namespace App\Bundle\LeoTelegramSdk\ArgumentResolver;

use App\Bundle\LeoTelegramSdk\ValueObject\MessageInterface;

interface MessageBuilderInterface
{
    public function build(): MessageInterface;
}
