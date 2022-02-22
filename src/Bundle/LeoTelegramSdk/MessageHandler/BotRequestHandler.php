<?php

declare(strict_types=1);

namespace App\Bundle\LeoTelegramSdk\MessageHandler;

use App\Bundle\LeoTelegramSdk\Message\BotRequestMessage;
use App\Bundle\LeoTelegramSdk\ValueObject\TextMessage;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use function get_class;
use function sprintf;

class BotRequestHandler implements MessageHandlerInterface
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

    public function __invoke(BotRequestMessage $message): void
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

        /** @var TextMessage $messageRequest */
//        $messageRequest = $this->serializer->deserialize($message->getMessage(), TextMessage::class, 'json');
//        $this->logger->debug(
//            sprintf(
//                '[%s]',
//                __METHOD__
//            ),
//            [
//                get_class($messageRequest) => $messageRequest->getMetadata()->getSdkMessageValueObjectClass(),
//                'text'=> $messageRequest->getText() ,
//            ]
//        );
    }
}
