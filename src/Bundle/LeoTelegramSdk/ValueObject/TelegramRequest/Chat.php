<?php

declare(strict_types=1);

namespace App\Bundle\LeoTelegramSdk\ValueObject\TelegramRequest;

use JetBrains\PhpStorm\Immutable;

#[Immutable]
class Chat
{
    protected int $id;
    protected string $firstName;
    protected string $lastName;
    protected string $userName;
    protected string $type;

    public function __construct(
        int $id,
        string $firstName,
        string $lastName,
        string $userName,
        string $type
    ) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->userName = $userName;
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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
    public function getType(): string
    {
        return $this->type;
    }
}
