<?php

declare(strict_types=1);

namespace App\Bundle\LeoTelegramSdk\Repository;

use App\Bundle\LeoTelegramSdk\Entity\Photo;
use App\Library\Repository\AbstractRepository;

class PhotoRepository extends AbstractRepository
{
    public const MODEL = Photo::class;
}
