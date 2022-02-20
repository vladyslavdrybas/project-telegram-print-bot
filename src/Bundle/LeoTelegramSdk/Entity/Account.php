<?php

declare(strict_types=1);

namespace App\Bundle\LeoTelegramSdk\Entity;

use App\Library\Entity\AbstractEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Bundle\LeoTelegramSdk\Repository\AccountRepository;

/**
 * @ORM\Entity(repositoryClass=AccountRepository::class)
 * @ORM\Table(name="telegram_account")
 */
class Account extends AbstractEntity
{
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected ?string $languageCode;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected ?string $firstName;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected ?string $lastName;
    /**
     * @ORM\Column(type="string", unique=true)
     */
    protected string $userName;
    /**
     * @ORM\Column(type="integer", unique=true)
     */
    protected int $telegramUserId;
    /**
     * @ORM\Column(type="boolean")
     */
    protected bool $isBot;
    /**
     * One telegram account has many photos. This is the inverse side.
     * @ORM\OneToMany(targetEntity="Photo", mappedBy="telegramAccount")
     * @Assert\Unique
     */
    protected Collection $telegramPhotos;

    public function __construct()
    {
        parent::__construct();
        $this->telegramPhotos = new ArrayCollection();
    }

    /**
     * @return string|null
     */
    public function getLanguageCode(): ?string
    {
        return $this->languageCode;
    }

    /**
     * @param string|null $languageCode
     */
    public function setLanguageCode(?string $languageCode): void
    {
        $this->languageCode = $languageCode;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string|null $firstName
     */
    public function setFirstName(?string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string|null $lastName
     */
    public function setLastName(?string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->userName;
    }

    /**
     * @param string $userName
     */
    public function setUserName(string $userName): void
    {
        $this->userName = $userName;
    }

    /**
     * @return int
     */
    public function getTelegramUserId(): int
    {
        return $this->telegramUserId;
    }

    /**
     * @param int $telegramUserId
     */
    public function setTelegramUserId(int $telegramUserId): void
    {
        $this->telegramUserId = $telegramUserId;
    }

    /**
     * @return bool
     */
    public function isBot(): bool
    {
        return $this->isBot;
    }

    /**
     * @param bool $isBot
     */
    public function setIsBot(bool $isBot): void
    {
        $this->isBot = $isBot;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection|\App\Bundle\LeoTelegramSdk\Entity\Photo[]
     */
    public function getTelegramPhotos(): ArrayCollection
    {
        return $this->telegramPhotos;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $telegramPhotos
     */
    public function setTelegramPhotos(ArrayCollection $telegramPhotos): void
    {
        foreach ($telegramPhotos as $telegramPhoto) {
            $this->addTelegramPhoto($telegramPhoto);
        }
    }

    /**
     * @param \App\Bundle\LeoTelegramSdk\Entity\Photo $telegramPhoto
     */
    public function addTelegramPhoto(Photo $telegramPhoto): void
    {
        $this->telegramPhotos->add($telegramPhoto);
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function unsetTelegramPhotos(): ArrayCollection
    {
        return $this->telegramPhotos = new ArrayCollection();
    }
}
