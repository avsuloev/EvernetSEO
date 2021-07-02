<?php

namespace App\Service\API;

use App\Contracts\Service\API\Consumers\ApiConcreteConsumerInterface;
use App\Contracts\Service\API\YMParametersStrategyInterface;
use App\Contracts\Service\API\YMPeriodStrategyInterface;
use App\Exception\Service\API\YandexMetrikaException;
use JetBrains\PhpStorm\ArrayShape;

class YandexMetrika implements ApiConcreteConsumerInterface
{
    private const API_CONSUMER_NAME = 'Yandex Metrika API';
    private const API_URI = 'https://api-metrika.yandex.net';
    private const V1_DATA_ENDPOINT = '/stat/v1/data';
    private const V1_DATA_HTTP_METHOD = 'GET';

    public function __construct(
        private int $counterId,
        private string $token,
        private YMParametersStrategyInterface $parametersStrategy,
        private ?YMPeriodStrategyInterface $periodStrategy,
        private ?int $limit,
        private ?string $consumerName = self::API_CONSUMER_NAME,
    ) {
    }

    public function generatePersistedQuery(): ApiPersistedQuery
    {
        return new ApiPersistedQuery(
            cacheKey: $this->generateCacheKey(),
            httpMethod: self::V1_DATA_HTTP_METHOD,
            httpUrl: self::V1_DATA_ENDPOINT,
            httpOptions: $this->generateHttpOptions(),
        );
    }

    /**
     * Cache key MUST follow PHP-FIG 'PSR-6: Caching Interface' standard.
     *
     * @see https://www.php-fig.org/psr/psr-6/ [PSR-6.Definitions.Key] — allowed characters.
     */
    private function generateCacheKey(): string
    {
        return sprintf(
            '%s.%s.%s.%s.limit_%s',
            $this->consumerName,
            $this->parametersStrategy->getCacheKey(),
            $this->periodStrategy->getStartDate(),
            $this->periodStrategy->getEndDate(),
            $this->limit ? (string) $this->limit : 'undefined',
        );
    }

    #[ArrayShape([
        'base_uri' => 'string',
        'headers' => 'string[]',
        'query' => 'array',
    ])]
    private function generateHttpOptions(): array
    {
        $limit = $this->generateLimit();
        $query = array_merge(
            $this->parametersStrategy->getQueryParameters(),
            $this->periodStrategy->getQueryParameters(),
            ['ids' => $this->counterId],
        );
        if (null !== $limit) {
            $query['limit'] = $limit;
        }

        return [
            'base_uri' => self::API_URI,
            'headers' => [
                'Content-Type' => 'application/x-yametrika+json',
                'Authorization' => "OAuth $this->token",
            ],
            'query' => $query,
        ];
    }

    private function generateLimit(): ?int
    {
        $this->parametersStrategy instanceof YMParametersStrategyInterface
            ?: throw new YandexMetrikaException("$this->consumerName: query parameters strategy is missing.");

        return $this->limit ?? $this->parametersStrategy->getLimit();
    }
}
