<?php

declare(strict_types=1);

namespace App\Bundle\LeoTelegramSdk\MessageHandler;

use App\Bundle\LeoTelegramSdk\Message\TelegramRequestMessage;
use App\Bundle\LeoTelegramSdk\ValueObject\TelegramRequest\TextRequest;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use function sprintf;

class TelegramRequestHandler implements MessageHandlerInterface
{
    protected SerializerInterface $serializer;
    protected LoggerInterface $logger;

    public function __construct(
        SerializerInterface $serializer,
        LoggerInterface $telegramLogger
    ) {
        $this->serializer = $serializer;
        $this->logger = $telegramLogger;
    }

    public function __invoke(TelegramRequestMessage $message): void
    {
        $this->logger->debug(
            sprintf(
                '[%s]',
                __METHOD__
            ),
            [
                $message->getMessage(),
            ]
        );

        /** @var TextRequest $messageRequest */
//        $messageRequest = $this->serializer->deserialize($message->getMessage(), TextRequest::class, 'json');
//        $this->logger->debug(
//            sprintf(
//                '[%s]',
//                __METHOD__
//            ),
//            [
//                get_class($messageRequest) => $messageRequest->getMetadata()->getClass(),
//                'text'=> $messageRequest->getText() ,
//            ]
//        );
    }
}
