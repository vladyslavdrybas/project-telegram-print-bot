<?php

declare(strict_types=1);

namespace App\Bundle\LeoTelegramSdk\ValueObject;

use DateTimeImmutable;

interface MessageInterface
{
    public function getUpdateId(): int;
    public function getMessageId(): int;
    public function getDate(): DateTimeImmutable;
    public function getFrom(): From;
    public function getChat(): Chat;
    public function getMetadata(): Metadata;
}
