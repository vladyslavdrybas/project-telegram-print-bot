<?php

declare(strict_types=1);

namespace App\Library\Entity;

use DateTime;
use Gedmo\Timestampable\Traits\Timestampable;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Component\Uid\UuidV4;
use Symfony\Component\Validator\Constraints as Assert;

class AbstractEntity implements EntityInterface
{
    use Timestampable;

    /**
     * @Assert\Uuid
     * @ORM\Id
     * @ORM\Column(name="id", type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UuidGenerator::class)
     */
    protected UuidV4 $id;

    public function __construct()
    {
        $this->id = new UuidV4();
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
    }

    /**
     * @return UuidV4
     */
    public function getId(): UuidV4
    {
        return $this->id;
    }

    /**
     * @param UuidV4 $id
     */
    public function setId(UuidV4 $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getEntityClass(): string
    {
        return static::class;
    }

    /**
     * @return string
     */
    #[Pure] public function __toString(): string
    {
        return $this->getId()->toRfc4122();
    }
}
