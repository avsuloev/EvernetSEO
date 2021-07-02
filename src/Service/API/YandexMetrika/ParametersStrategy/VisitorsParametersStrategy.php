<?php

namespace App\Service\API\YandexMetrika\ParametersStrategy;

use App\Contracts\Service\API\YMParametersStrategyInterface;

/**
 * API data about site visits (visits, pageviews, users).
 */
class VisitorsParametersStrategy implements YMParametersStrategyInterface
{
    use YMQueryStrategyTrait;

    private array $queryParameters = [
        'metrics' => 'ym:s:visits,ym:s:pageviews,ym:s:users',
        'dimensions' => 'ym:s:date',
        'sort' => 'ym:s:date',
    ];
}
