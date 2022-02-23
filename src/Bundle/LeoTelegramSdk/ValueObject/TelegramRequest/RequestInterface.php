<?php

declare(strict_types=1);

namespace App\Bundle\LeoTelegramSdk\ValueObject\TelegramRequest;

use DateTimeImmutable;

interface RequestInterface
{
    public function getUpdateId(): int;
    public function getMessageId(): int;
    public function getDate(): DateTimeImmutable;
    public function getFrom(): From;
    public function getChat(): Chat;
    public function getMetadata(): Metadata;
}
