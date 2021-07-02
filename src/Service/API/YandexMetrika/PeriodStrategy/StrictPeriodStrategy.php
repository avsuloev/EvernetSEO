<?php

namespace App\Service\API\YandexMetrika\PeriodStrategy;

use App\Contracts\Service\API\YMPeriodStrategyInterface;

/**
 * API data for strict period
 * from $startDate 'Y-m-d'
 * to $endDate 'Y-m-d'.
 */
class StrictPeriodStrategy implements YMPeriodStrategyInterface
{
    use YMPeriodStrategyTrait;

    public function __construct(
        string $startDate,
        string $endDate,
    ) {
        $this->parameters = [
            'date1' => $startDate,
            'date2' => $endDate,
        ];
    }

    public function getQueryParameters(): array
    {
        return $this->parameters;
    }
}
