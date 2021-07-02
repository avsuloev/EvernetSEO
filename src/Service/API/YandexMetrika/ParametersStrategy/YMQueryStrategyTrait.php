<?php

namespace App\Service\API\YandexMetrika\ParametersStrategy;

/**
 * @property array $queryParameters
 */
trait YMQueryStrategyTrait
{
    public function __construct(
        private ?int $limit,
        private ?string $cacheKey,
    ) {}

    public function getQueryParameters(): array
    {
        return $this->queryParameters;
    }

    public function getLimit(): ?int
    {
        return $this->limit;
    }

    public function getCacheKey(): string
    {
        $this->cacheKey = $this->cacheKey ?? (new \ReflectionClass($this))->getShortName();

        return $this->cacheKey;
    }
}
