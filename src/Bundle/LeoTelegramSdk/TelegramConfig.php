<?php

declare(strict_types=1);

namespace App\Bundle\LeoTelegramSdk;

use App\Library\BundleComponent\Config\AbstractBundleConfig;

class TelegramConfig extends AbstractBundleConfig
{
    public const TELEGRAM_ENABLE = 'api|telegram_bot|enable';
    public const TELEGRAM_HTTP_API_TOKEN = 'api|telegram_bot|connection|telegram|token|value';
    public const TELEGRAM_HTTP_API_HOST = 'api|telegram_bot|connection|telegram|host|value';
    public const TELEGRAM_BOT_HOST = 'api|telegram_bot|connection|bot|host|value';

    public const WEBHOOK_REGISTER_ENDPOINT = 'api|telegram_bot|endpoints|webhook_register';
    public const CONNECTIONS = 'api|telegram_bot|connection';
}
