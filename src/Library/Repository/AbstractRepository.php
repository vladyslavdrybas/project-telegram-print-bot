<?php

declare(strict_types=1);

namespace App\Library\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Selectable;
use Doctrine\Persistence\ManagerRegistry;

abstract class AbstractRepository extends ServiceEntityRepository implements Selectable
{
    public const MODEL = '';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, static::MODEL);
    }
}
