<?php

namespace App\Service\API\YandexMetrika\ParametersStrategy;

use App\Contracts\Service\API\YMParametersStrategyInterface;

/**
 * API data for site visitors age and sex.
 */
class AgeGenderParametersStrategy implements YMParametersStrategyInterface
{
    use YMQueryStrategyTrait;

    private array $queryParameters = [
        'preset' => 'age_gender',
    ];
}
