<?php

declare(strict_types=1);

namespace App\Bundle\LeoTelegramSdk\ValueObject\TelegramRequest;

class DocumentRequest extends AbstractRequest
{
    protected Document $document;

    public function __construct(
        RequestBase $messageBase,
        Document     $document
    ) {
        parent::__construct($messageBase);
        $this->document = $document;
    }

    /**
     * @return \App\Bundle\LeoTelegramSdk\ValueObject\TelegramRequest\Document
     */
    public function getDocument(): Document
    {
        return $this->document;
    }
}