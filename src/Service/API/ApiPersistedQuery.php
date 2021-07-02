<?php

namespace App\Service\API;

use App\Contracts\Service\API\ApiPersistedQueryInterface;

class ApiPersistedQuery implements ApiPersistedQueryInterface
{
    public function __construct(
        private string $cacheKey,
        private string $httpMethod,
        private string $httpUrl,
        private array $httpOptions,
    ) {
    }

    public function getCacheKey(): string
    {
        return $this->cacheKey;
    }

    public function getHttpMethod(): string
    {
        return $this->httpMethod;
    }

    public function getHttpUrl(): string
    {
        return $this->httpUrl;
    }

    public function getHttpOptions(): array
    {
        return $this->httpOptions;
    }
}
