<?php

namespace App\Service\API\YandexMetrika\ParametersStrategy;

use App\Contracts\Service\API\YMParametersStrategyInterface;

/**
 * API data for site visitors countries and regions.
 */
class GeoParametersStrategy implements YMParametersStrategyInterface
{
    use YMQueryStrategyTrait;
    /**
     * Id страны(225 - Россия, 187 - Украина... и т.п.) для гео-сервисов Яндекса.
     */
    private const RUSSIA_REGION_COUNTRY_ID = 225;

    private array $queryParameters = [
        'dimensions' => 'ym:s:regionCountry,ym:s:regionArea',
        'metrics' => 'ym:s:visits',
        'sort' => '-ym:s:visits',
    ];
}
