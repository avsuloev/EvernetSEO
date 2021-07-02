<?php

namespace App\Service\API\YandexMetrika;

use App\Contracts\Service\API\ApiReturnedDataInterface;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Immutable;

#[Immutable]
class YmReturnedData implements ApiReturnedDataInterface
{
    private ?array $dataFormatted;

    public function __construct(
        private array $data,
    ) {
        $this->dataFormatted = $this->formatData();
    }

    public function getData(): ?array
    {
        if (null === $this->dataFormatted) {
            $this->formatData();
        }

        return $this->dataFormatted;
    }

    public function getRawData(): ?array
    {
        return $this->data;
    }

    #[ArrayShape([
        'data' => 'array',
        'totals' => 'array',
        'min' => 'array',
        'max' => 'array',
    ])]
    private function formatData(): array
    {
        $rawData = $this->data;
        $formatted = [
            'data' => [],
            'totals' => $this->combineData('metrics', $rawData['totals']),
            'min' => $this->combineData('metrics', $rawData['min']),
            'max' => $this->combineData('metrics', $rawData['max']),
        ];

        foreach ($rawData['data'] as $key => $datum) {
            $formatted['data'][$key] = [
                'dimensions' => $this->combineData('dimensions', $datum['dimensions']),
                'metrics' => $this->combineData('metrics', $datum['metrics']),
            ];
        }

        return $formatted;
    }

    /**
     * Merging arrays to form array keys.
     */
    private function combineData(
        string $column,
        array $array,
    ): array {
        $queryColumn = array_map(
            static function (string $key) {
                return str_replace(['ym:s:', 'ym:pv:', 'ym:ad:', 'ym:sp:'], '', $key);
            },
            $this->data['query'][$column]
        );

        return array_combine($queryColumn, $array);
    }
}
