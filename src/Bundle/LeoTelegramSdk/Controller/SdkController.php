<?php

declare(strict_types=1);

namespace App\Bundle\LeoTelegramSdk\Controller;

use App\Bundle\LeoTelegramSdk\Message\TelegramRequestMessage;
use App\Bundle\LeoTelegramSdk\Service\Builder\MessageBuilderInterface;
use App\Library\BundleComponent\Config\ConfigBundleInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use function assert;
use function get_class;
use function in_array;
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
     * @var MessageBusInterface
     */
    protected MessageBusInterface $messageBus;

    /**
     * @var SerializerInterface
     */
    protected SerializerInterface $serializer;

    /**
     * @param \Symfony\Contracts\HttpClient\HttpClientInterface $httpClient
     * @param \Psr\Log\LoggerInterface $telegramLogger
     * @param MessageBusInterface $messageBus
     */
    public function __construct(
        HttpClientInterface $httpClient,
        LoggerInterface $telegramLogger,
        MessageBusInterface $messageBus,
        SerializerInterface $serializer
    ) {
        $this->httpClient = $httpClient;
        $this->telegramLogger = $telegramLogger;
        $this->messageBus = $messageBus;
        $this->serializer = $serializer;
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
            $this->telegramLogger->debug('disabled', [$telegramConfig->isEnable()]);
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
            $this->telegramLogger->debug('disabled', [$telegramConfig->isEnable()]);
            return new JsonResponse([], JsonResponse::HTTP_NOT_FOUND);
        }

        $telegramRequest = $telegramMessageBuilder->build();
        $this->telegramLogger->debug(
            sprintf(
                '[%s][%s]',
                static::class,
                $telegramRequest->getMetadata()->getType()
            ),
            [
                $telegramRequest->getMetadata()->getClass(),
                $telegramRequest->getMetadata()->getType(),
                $telegramRequest->getMetadata()->isCommandRequest(),
                $telegramRequest->getMetadata()->isTextRequest(),
                (array) $telegramRequest
            ]
        );

        $message = new TelegramRequestMessage($this->serializer->serialize($telegramRequest, 'json'));
        $this->messageBus->dispatch($message);

//        if ($telegramMessage instanceof PhotoRequest) {
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
            $this->telegramLogger->debug('disabled', [$telegramConfig->isEnable()]);
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
