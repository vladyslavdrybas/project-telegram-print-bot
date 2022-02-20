<?php

declare(strict_types=1);

namespace App\Library\Entity;

use Symfony\Component\Uid\Uuid;

interface EntityInterface
{
    /**
     * @return string
     */
    public function getEntityClass(): string;

    /**
     * @return \Symfony\Component\Uid\Uuid
     */
    public function getId(): Uuid;
}
