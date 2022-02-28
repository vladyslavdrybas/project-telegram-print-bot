<?php

declare(strict_types=1);

namespace App\Library\Traits;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use function array_shift;
use function assert;
use function explode;
use function filter_var;
use function is_string;
use function ltrim;
use function preg_replace_callback;
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

    /**
     * @param array|null $parameters
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

        $value = $default;
        if (str_contains($key, '|')) {
            $keySplitted = explode('|', $key);
            $key = array_shift($keySplitted);
            assert(strlen($key) > 0);
            $value = $parameters[$key] ?? null;
            if ($value === null) {
                $value = $default;
            } else {
                while (count($keySplitted) > 0) {
                    $key = array_shift($keySplitted);
                    $value = $value[$key] ?? null;
                    if ($value === null) {
                        $value = $default;
                        break;
                    }
                }
            }
        }

        if (is_string($value)) {
            $value = $this->replaceStringSubValue($value);
        }

        return $value;
    }

    /**
     * @param string $value
     * @return string
     */
    protected function replaceStringSubValue(string $value): string
    {
        $config = $this;

        return preg_replace_callback(
            '/{[^{}]+}/',
            function ($matches) use ($config) {
                dump($matches);
                return $config->findString($matches[0], null, '');
            },
            $value
        );
    }
}
