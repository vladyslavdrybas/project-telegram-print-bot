<?php

declare(strict_types=1);

namespace App\Library\Traits;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use function array_shift;
use function explode;
use function filter_var;
use function ltrim;
use function rtrim;
use function str_contains;
use function strlen;
use const FILTER_VALIDATE_BOOL;

trait ConfigAwareTrait
{
    /**
     * @var \Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface
     */
    protected ParameterBagInterface $parameterBag;

    /**
     * @required
     * @param \Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface $parameterBag
     */
    public function setParameterBag(ParameterBagInterface $parameterBag): void
    {
        $this->parameterBag = $parameterBag;
    }

    /**
     * @param array $parameters
     * @param string $key
     * @param float|array|bool|int|string|null $default
     * @return array|bool|string|int|float|null
     */
    protected function find(string $key, float|array|bool|int|string $default = null, ?array $parameters = null): float|int|bool|array|string|null
    {
        if ($parameters === null) {
            $parameters = $this->parameterBag->all();
        }

        if (isset($parameters[$key])) {
            return $parameters[$key];
        }

        $key = ltrim($key, '{');
        $key = rtrim($key, '}');

        $value = null;
        if (str_contains($key, '|')) {
            $keySplitted = explode('|', $key);
            $key = array_shift($keySplitted);
            assert(strlen($key) > 0);
            $value = $parameters[$key] ?? null;
            if ($value === null) {
                return $default;
            }

            while (count($keySplitted) > 0) {
                $key = array_shift($keySplitted);
                $value = $value[$key] ?? null;
                if ($value === null) {
                    return $default;
                }
            }
        }

        return $value ?? $default;
    }

    public function findArray(string $key, ?array $parameters = null, ?array $default = null): ?array
    {
        return $this->find($key, $default, $parameters);
    }

    public function findString(string $key, ?array $parameters = null, ?string $default = null): ?string
    {
        return $this->find($key, $default, $parameters);
    }

    public function findInt(string $key, ?array $parameters = null, ?int $default = null): ?int
    {
        return $this->find($key, $default, $parameters);
    }

    public function findFloat(string $key, ?array $parameters = null, ?float $default = null): ?float
    {
        return $this->find($key, $default, $parameters);
    }

    public function findBool(string $key, ?array $parameters = null, bool $default = false): bool
    {
        return filter_var($this->find($key, $default, $parameters), FILTER_VALIDATE_BOOL);
    }
}
