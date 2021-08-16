<?php

namespace App\Service\API\YandexMetrika\ParametersStrategy;

use App\Contracts\Service\API\YMParametersStrategyInterface;

class CustomParametersStrategy implements YMParametersStrategyInterface
{
    use YMQueryStrategyTrait;

    public function __construct(
        private array $queryParameters,
        private ?int $limit,
        private ?string $cacheKey,
    ) {}

    public function getCacheKey(): string
    {
        $this->cacheKey ??= (new \ReflectionClass($this))->getShortName();

        return $this->cacheKey.md5(serialize($this->queryParameters));
    }
}
