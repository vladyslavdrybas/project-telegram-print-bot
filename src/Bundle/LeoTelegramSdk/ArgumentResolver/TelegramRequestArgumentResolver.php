<?php

declare(strict_types=1);

namespace App\Bundle\LeoTelegramSdk\ArgumentResolver;

use App\Bundle\LeoTelegramSdk\Service\Builder\TelegramRequestBuilder;
use App\Bundle\LeoTelegramSdk\Service\Builder\MessageBuilderInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class TelegramRequestArgumentResolver implements ArgumentValueResolverInterface
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected LoggerInterface $telegramLogger;

    public function __construct(
        LoggerInterface $telegramLogger
    ) {
        $this->telegramLogger = $telegramLogger;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata $argument
     * @return bool
     */
    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        if ($argument->getType() === MessageBuilderInterface::class) {
            $this->telegramLogger->debug(
                sprintf(
                    '[%s][%s]',
                    TelegramRequestArgumentResolver::class,
                    $argument->getType() ?? 'Unknown'
                ),
                [
                    'request-content' => $request->toArray(),
                    'request-path-info' => $request->getPathInfo(),
                    'argument' => $argument->getType(),
                ]
            );

            return true;
        }

        return false;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter) $argument declaration in the ArgumentValueResolverInterface
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata $argument
     * @return \Generator
     */
    public function resolve(Request $request, ArgumentMetadata $argument): \Generator
    {
        yield new TelegramRequestBuilder($request, $this->telegramLogger);
    }
}
