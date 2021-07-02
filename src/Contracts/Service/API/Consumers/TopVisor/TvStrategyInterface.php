<?php

namespace App\Contracts\Service\API\Consumers\TopVisor;

interface TvStrategyInterface
{
    public function getQueryParameters(): array;
    public function getLimit(): ?int;
    public function getCacheKey(): string;
}
