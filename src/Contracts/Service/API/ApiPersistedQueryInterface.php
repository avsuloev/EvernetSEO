<?php

namespace App\Contracts\Service\API;

interface ApiPersistedQueryInterface
{
    public function getCacheKey(): string;
    public function getHttpMethod(): string;
    public function getHttpUrl(): string;
    public function getHttpOptions(): array;
}
