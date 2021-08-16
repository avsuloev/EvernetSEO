<?php

namespace App\Service\API\YandexMetrika\ParametersStrategy;

use App\Contracts\Service\API\YMParametersStrategyInterface;

/**
 * API data for string $presetName preset.
 */
class PresetParametersStrategy implements YMParametersStrategyInterface
{
    use YMQueryStrategyTrait;

    private array $queryParameters = [
        'date1' => null,
        'date2' => null,
        'preset' => null,
        'limit' => null,
    ];

    public function __construct(
        private string $presetName,
        private ?int $limit,
        private ?string $cacheKey,
    ) {}

    public function getCacheKey(): string
    {
        $this->cacheKey ??= (new \ReflectionClass($this))->getShortName();

        return $this->cacheKey."_$this->presetName";
    }
}
