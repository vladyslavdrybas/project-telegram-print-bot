<?php

declare(strict_types=1);

namespace App\Bundle\LeoTelegramSdk\ValueObject\TelegramRequest;

class CommandRequest extends AbstractRequest
{
    protected string $command;

    public function __construct(
        RequestBase $messageBase,
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
