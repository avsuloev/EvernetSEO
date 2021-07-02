<?php

namespace App\Service\API\YandexMetrika\ParametersStrategy;

use App\Contracts\Service\API\YMParametersStrategyInterface;

/**
 * API data for site visitors browsers.
 */
class BrowsersParametersStrategy implements YMParametersStrategyInterface
{
    use YMQueryStrategyTrait;

    private array $queryParameters = [
        'preset' => 'tech_platforms',
        'dimensions' => 'ym:s:browser',
    ];
}
