<?php

declare(strict_types=1);

namespace App\Bundle\LeoTelegramSdk;

use App\Library\BundleComponent\Config\AbstractBundleConfig;
use function explode;
use function filter_var;

class TelegramConfig extends AbstractBundleConfig
{
    public const TELEGRAM_ENABLE = 'api|telegram_bot|enable';

    public const WEBHOOK_REGISTER_ENDPOINT = 'api|telegram_bot|endpoint|webhook_register';
    public const SEND_MESSAGE_ENDPOINT = 'api|telegram_bot|endpoint|send_message';

    public const CONNECTIONS = 'api|telegram_bot|connection';
    public const TEST_CHAT_IDS = 'api|telegram_bot|test_chat_ids';

    protected array $sendMessageEndpoint = [];
    protected array $webhookRegisterEndpoint = [];
    protected array $connections = [];
    protected array $testChatIds = [];
    protected bool $isEnable = false;

    public function isEnable(): bool
    {
        if (empty($this->isEnable)) {
            $this->isEnable = $this->findBool(TelegramConfig::TELEGRAM_ENABLE);
        }

        return $this->isEnable;
    }


    public function getAllowedTestChatIds(): array
    {
        if (empty($this->testChatIds)) {
            $this->testChatIds = explode(',', $this->findString(TelegramConfig::TEST_CHAT_IDS, null, ''));
        }

        return $this->testChatIds;
    }

    public function getConnections(): array
    {
        if (empty($this->connections)) {
            $this->connections = $this->findArray(TelegramConfig::CONNECTIONS);
        }

        return $this->connections;
    }

    public function getWebhookRegisterEndpoint(): array
    {
        if (empty($this->webhookRegisterEndpoint)) {
            $this->webhookRegisterEndpoint = $this->findArray(TelegramConfig::WEBHOOK_REGISTER_ENDPOINT);
        }

        return $this->webhookRegisterEndpoint;
    }

    public function getSendMessageEndpoint(): array
    {
        if (empty($this->sendMessageEndpoint)) {
            $this->sendMessageEndpoint = $this->findArray(TelegramConfig::SEND_MESSAGE_ENDPOINT);
        }

        return $this->sendMessageEndpoint;
    }

    public function getSendMessageEndpointMethod(): string
    {
        return $this->findString('method', $this->getSendMessageEndpoint(), 'POST');
    }

    public function getSendMessageEndpointUrl(): string
    {
        return $this->findString(
            $this->findString('connection', $this->getSendMessageEndpoint(), ''),
            $this->getConnections()
        ) . $this->findString('path', $this->getSendMessageEndpoint(), '');
    }
}
