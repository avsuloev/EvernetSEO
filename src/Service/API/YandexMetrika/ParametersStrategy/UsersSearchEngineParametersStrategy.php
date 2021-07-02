<?php

namespace App\Service\API\YandexMetrika\ParametersStrategy;

use App\Contracts\Service\API\YMParametersStrategyInterface;

/**
 * API data for site visitors search engines.
 */
class UsersSearchEngineParametersStrategy implements YMParametersStrategyInterface
{
    use YMQueryStrategyTrait;

    private array $queryParameters = [
        'metrics' => 'ym:s:users',
        'dimensions' => 'ym:s:searchEngine',
        'filters' => "ym:s:trafficSource=='organic'",
    ];
}
