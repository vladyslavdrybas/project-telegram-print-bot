<?php

declare(strict_types=1);

namespace App\Bundle\LeoTelegramSdk\Controller;

use App\Bundle\LeoTelegramSdk\ArgumentResolver\MessageBuilderInterface;
use App\Bundle\LeoTelegramSdk\TelegramConfig;
use App\Library\BundleComponent\Config\ConfigBundleInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use function assert;
use function get_class;
use function in_array;
use function is_array;
use function sprintf;

/**
 * @package App\Controller\Telegram
 */
class SdkController extends AbstractController
{
    /**
     * @var \Symfony\Contracts\HttpClient\HttpClientInterface
     */
    protected HttpClientInterface $httpClient;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected LoggerInterface $telegramLogger;

    /**
     * @param \Symfony\Contracts\HttpClient\HttpClientInterface $httpClient
     * @param \Psr\Log\LoggerInterface $telegramLogger
     */
    public function __construct(HttpClientInterface $httpClient, LoggerInterface $telegramLogger)
    {
        $this->httpClient = $httpClient;
        $this->telegramLogger = $telegramLogger;
    }

    /**
     * @Route("/bot/entrypoint/register", name="bot/entrypoint_register", methods={"GET"})
     *
     * @param \App\Library\BundleComponent\Config\ConfigBundleInterface $telegramConfig
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function entrypointRegister(ConfigBundleInterface $telegramConfig): JsonResponse
    {
        if (!$telegramConfig->isEnable()) {
            return new JsonResponse([], JsonResponse::HTTP_NOT_FOUND);
        }

        $url = $telegramConfig->getWebhookRegisterEndpointUrl();
        $method = $telegramConfig->getWebhookRegisterEndpointMethod();

        $this->telegramLogger->debug(
            sprintf(
                '[%s]',
                __METHOD__
            ),
            [
                'url' => $url,
                'method' => $method,
            ]
        );

        $response = $this->httpClient->request($method, $url);

        $level = 'debug';
        if ($response->getStatusCode() !== 200) {
            $level = 'error';
        }
        $this->telegramLogger->log(
            $level,
            sprintf(
                '[%s][%s]',
                __METHOD__,
                get_class($response)
            ),
            [
                'status' => $response->getStatusCode(),
                'content' => $response->toArray(false),
            ]
        );

        return new JsonResponse([
                'status' => $response->getStatusCode(),
                'content' => $response->toArray(false),
            ]);
    }

    /**
     * @Route("/bot/entrypoint", name="bot_entrypoint", methods={"POST"})
     *
     * @param MessageBuilderInterface $telegramMessageBuilder
     * @param ConfigBundleInterface $telegramConfig
     *
     * @return Response
     */
    public function entrypoint(
        MessageBuilderInterface $telegramMessageBuilder,
        ConfigBundleInterface $telegramConfig
    ): Response {
        if (!$telegramConfig->isEnable()) {
            return new JsonResponse([], JsonResponse::HTTP_NOT_FOUND);
        }

        $telegramMessage = $telegramMessageBuilder->buildMessage();
        $this->telegramLogger->debug(
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

    /**
     * Use this endpoint to send every 10 minutes healthcare request from the server to telegram
     *
     * @Route("/bot/connection/test", name="bot_connection_test", methods={"GET"})
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \App\Library\BundleComponent\Config\ConfigBundleInterface $telegramConfig
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function connectionTest(
        Request $request,
        ConfigBundleInterface $telegramConfig
    ): JsonResponse
    {
        if (!$telegramConfig->isEnable()) {
            return new JsonResponse([], JsonResponse::HTTP_NOT_FOUND);
        }

        $chatId = $request->get('chatId');
        assert(in_array($chatId, $telegramConfig->getAllowedTestChatIds()));

        $params = [
            'chat_id' => $chatId,
            'text' => 'Test:Pass. Stable connection.',
        ];

        $query = http_build_query($params);

        $url = $telegramConfig->getSendMessageEndpointUrl() . '?' . $query;

        $this->telegramLogger->debug(
            sprintf(
                '[%s]',
                __METHOD__
            ),
            [
                'url' => $url,
                'method' => $telegramConfig->getSendMessageEndpointMethod(),
            ]
        );
        $response = $this->httpClient->request($telegramConfig->getSendMessageEndpointMethod(), $url);

        $level = 'debug';
        if ($response->getStatusCode() !== 200) {
            $level = 'error';
        }
        $this->telegramLogger->log(
            $level,
            sprintf(
                '[%s][%s]',
                __METHOD__,
                get_class($response)
            ),
            [
                'status' => $response->getStatusCode(),
                'content' => $response->toArray(false),
            ]
        );

        return new JsonResponse([
            'status' => $response->getStatusCode(),
            'content' => $response->toArray(false),
        ]);
    }
}
