<?php

declare(strict_types=1);

namespace App\Library\BundleComponent\Config;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

interface ConfigBundleInterface
{
    public function findArray(string $key, ?array $parameters = null, ?array $default = null): ?array;
    public function findString(string $key, ?array $parameters = null, ?string $default = null): ?string;
    public function findInt(string $key, ?array $parameters = null, ?int $default = null): ?int;
    public function findFloat(string $key, ?array $parameters = null, ?float $default = null): ?float;
    public function findBool(string $key, ?array $parameters = null, ?bool $default = null): ?bool;

    /**
     * @param \Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface $parameterBag
     */
    public function setParameterBag(ParameterBagInterface $parameterBag): void;
}
