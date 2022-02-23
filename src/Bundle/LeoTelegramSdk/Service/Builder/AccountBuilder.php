<?php

declare(strict_types=1);

namespace App\Bundle\LeoTelegramSdk\Service\Builder;

use App\Bundle\LeoTelegramSdk\Entity\Account;
use App\Bundle\LeoTelegramSdk\ValueObject\TelegramRequest\RequestInterface;

class AccountBuilder
{
    public function build(
        RequestInterface $message
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
