<?php

declare(strict_types=1);

namespace App\Bundle\LeoTelegramSdk\Service\Builder;

use App\Bundle\LeoTelegramSdk\ValueObject\MessageInterface;
use App\Bundle\LeoTelegramSdk\Entity\Account;

class AccountBuilder
{
    public function build(
        MessageInterface $message
    ): Account {
        $telegramAccount = new Account();
        $telegramAccount->setFirstName($message->getFrom()->getFirstName());
        $telegramAccount->setLastName($message->getFrom()->getLastName());
        $telegramAccount->setUserName($message->getFrom()->getUserName());
        $telegramAccount->setLanguageCode($message->getFrom()->getLanguageCode());
        $telegramAccount->setIsBot($message->getFrom()->isBot());
        $telegramAccount->setTelegramUserId($message->getFrom()->getId());

        return $telegramAccount;
    }
}
