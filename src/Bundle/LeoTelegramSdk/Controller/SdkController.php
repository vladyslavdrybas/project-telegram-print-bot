<?php

declare(strict_types=1);

namespace App\Bundle\LeoTelegramSdk\Controller;

use App\Bundle\LeoTelegramSdk\TelegramConfig;
use App\Library\BundleComponent\Config\ConfigBundleInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use function assert;
use function is_array;

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
     * @Route("/entrypoint/register", name="entrypoint_register", methods={"GET"})
     *
     * @param \App\Library\BundleComponent\Config\ConfigBundleInterface $telegramConfig
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     *
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function webhookRegister(ConfigBundleInterface $telegramConfig): JsonResponse
    {
        $params = [];
        $connections = $telegramConfig->findArray(TelegramConfig::CONNECTIONS);
        assert(is_array($connections));
        $webhookRegisterEndpoint = $telegramConfig->findArray(TelegramConfig::WEBHOOK_REGISTER_ENDPOINT);
        assert(is_array($webhookRegisterEndpoint));

        //@todo move sub params default value extraction into the \App\Library\Traits\ConfigAwareTrait
        $urlParameterKey = $telegramConfig->findString('fields|url|name', $webhookRegisterEndpoint, 'url') ;
        assert($urlParameterKey !== null);

        $params[$urlParameterKey] = preg_replace_callback(
                '/{[^{}]+}/',
                function ($matches) use ($telegramConfig) {
                    return $telegramConfig->findString($matches[0], null, '');
                },
                $telegramConfig->findString('fields|url|default', $webhookRegisterEndpoint, '')
            );

        $connection = $telegramConfig->findString(
            $telegramConfig->findString('connection', $webhookRegisterEndpoint, '') . '|host|value',
            $connections
        );
        assert($connection !== null);

        $url = $connection
            . $telegramConfig->findString('path', $webhookRegisterEndpoint)
            . '?url=' . $params[$urlParameterKey];

        $method = $telegramConfig->findString('method', $webhookRegisterEndpoint, 'GET');
        $registerResponse = $this->httpClient->request($method, $url);

        return new JsonResponse([
                'telegramResponseStatus' => $registerResponse->getStatusCode(),
                'telegramResponseContent' => $registerResponse->toArray(false),
            ]);
    }
}
