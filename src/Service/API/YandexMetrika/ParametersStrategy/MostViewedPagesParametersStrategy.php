<?php

namespace App\Service\API\YandexMetrika\ParametersStrategy;

use App\Contracts\Service\API\YMParametersStrategyInterface;

/**
 * API data for most popular web pages.
 */
class MostViewedPagesParametersStrategy implements YMParametersStrategyInterface
{
    use YMQueryStrategyTrait;

    private array $queryParameters = [
        'metrics' => 'ym:pv:pageviews',
        'dimensions' => 'ym:pv:URLPathFull,ym:pv:title',
        'sort' => '-ym:pv:pageviews',
    ];
}
