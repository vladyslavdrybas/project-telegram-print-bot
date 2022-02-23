<?php

declare(strict_types=1);

namespace App\Bundle\LeoTelegramSdk\Service\Builder;

use App\Bundle\LeoTelegramSdk\ValueObject\TelegramRequest\RequestInterface;

interface MessageBuilderInterface
{
    public function build(): RequestInterface;
}
