<?php

declare(strict_types=1);

namespace App\Bundle\LeoTelegramSdk\Repository;

use App\Bundle\LeoTelegramSdk\Entity\Account;
use App\Library\Repository\AbstractRepository;

/**
 * @method Account|null find($id, $lockMode = null, $lockVersion = null)
 * @method Account|null findOneBy(array $criteria, array $orderBy = null)
 * @method Account[]    findAll()
 * @psalm-method list<Account>    findAll()
 * @method Account[]   findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @psalm-method list<Account>   findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AccountRepository extends AbstractRepository
{
    public const MODEL = Account::class;

    /**
     * @param \App\Bundle\LeoTelegramSdk\Entity\Account $telegramAccount
     * @return \App\Bundle\LeoTelegramSdk\Entity\Account
     */
    public function getExistedOrNew(Account $telegramAccount): Account
    {
        return $this->findOneBy([
            'telegramUserId' => $telegramAccount->getTelegramUserId(),
        ]) ?? $telegramAccount;
    }
}
