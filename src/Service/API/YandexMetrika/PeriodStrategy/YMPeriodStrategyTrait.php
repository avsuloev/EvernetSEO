<?php

namespace App\Service\API\YandexMetrika\PeriodStrategy;

trait YMPeriodStrategyTrait
{
    private array $parameters;
    private string $startDate;
    private string $endDate;

    public function getQueryParameters(): array
    {
        return $this->parameters;
    }

    public function getStartDate(): string
    {
        return $this->startDate;
    }

    public function getEndDate(): string
    {
        return $this->endDate;
    }
}
