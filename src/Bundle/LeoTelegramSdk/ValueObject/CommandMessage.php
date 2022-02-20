<?php

declare(strict_types=1);

namespace App\Bundle\LeoTelegramSdk\ValueObject;

class CommandMessage extends AbstractMessage
{
    protected string $command;

    public function __construct(
        MessageBase $messageBase,
        string      $command
    ) {
        parent::__construct($messageBase);
        $this->command = $command;
    }

    /**
     * @return string
     */
    public function getCommand(): string
    {
        return $this->command;
    }
}
