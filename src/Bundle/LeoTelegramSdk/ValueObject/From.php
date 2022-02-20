<?php

declare(strict_types=1);

namespace App\Bundle\LeoTelegramSdk\ValueObject;

use JetBrains\PhpStorm\Immutable;

#[Immutable]
class From
{
    protected int $id;
    protected bool $isBot;
    protected string $firstName;
    protected string $lastName;
    protected string $userName;
    protected string $languageCode;

    public function __construct(
        int $id,
        bool $isBot,
        string $firstName,
        string $lastName,
        string $userName,
        string $languageCode
    ) {
        $this->id = $id;
        $this->isBot = $isBot;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->userName = $userName;
        $this->languageCode = $languageCode;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function isBot(): bool
    {
        return $this->isBot;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->userName;
    }

    /**
     * @return string
     */
    public function getLanguageCode(): string
    {
        return $this->languageCode;
    }
}
