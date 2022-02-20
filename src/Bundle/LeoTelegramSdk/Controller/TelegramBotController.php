<?php

declare(strict_types=1);

namespace App\Bundle\LeoTelegramSdk\Controller;

use App\Bundle\LeoTelegramSdk\ArgumentResolver\MessageBuilderInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TelegramBotController extends AbstractController
{
    /**
     * @Route("/bot/entrypoint", name="bot_entrypoint", methods={"POST"})
     *
     * @param MessageBuilderInterface $telegramMessageBuilder
     * @param \Psr\Log\LoggerInterface $telegramLogger
     *
     * @return Response
     */
    public function main(
        MessageBuilderInterface $telegramMessageBuilder,
        LoggerInterface         $telegramLogger
    ): Response {
        $telegramMessage = $telegramMessageBuilder->buildMessage();
        $telegramLogger->debug(
            sprintf(
                '[%s][%s]',
                static::class,
                $telegramMessage->getMetadata()->getType()
            ),
            [
                $telegramMessage->getMetadata()->getSdkMessageValueObjectClass(),
                $telegramMessage->getMetadata()->getType(),
                $telegramMessage->getMetadata()->isCommandMessage(),
                $telegramMessage->getMetadata()->isTextMessage(),
                (array) $telegramMessage
            ]
        );

//        if ($telegramMessage instanceof PhotoMessage) {
//            $telegramAccount = $telegramAccountFromTelegramMessageBuilder->build($telegramMessage);
//            $telegramAccount = $entityManager->getRepository(Account::class)->getExistedOrNew($telegramAccount);
//
//            $photos = $telegramMessage->getPhotos()->getArrayCopy();
//            $photo = array_pop($photos);
//            $telegramPhoto = $userFromTelegramMessageBuilder->build($telegramMessage, $photo, $telegramAccount);
//            $entityManager->persist($telegramPhoto);
//            $entityManager->flush();
//        }

        return new Response('', Response::HTTP_OK);
    }
}
