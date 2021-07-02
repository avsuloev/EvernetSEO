<?php

namespace App\Service\API;

use App\Contracts\Service\API\Consumers\ApiConcreteConsumerInterface;
use App\Contracts\Service\API\Consumers\TopVisor\TvStrategyInterface;
use JetBrains\PhpStorm\ArrayShape;

class TopVisor implements ApiConcreteConsumerInterface
{
    private const API_CONSUMER_NAME = 'Top Visor API';
    private const API_URL = 'https://api.topvisor.ru';
    private const V2_JSON_GET_ENDPOINT = '/v2/json/get';
    private const V2_DATA_HTTP_METHOD = 'POST';

    public function __construct(
        private int $userId,
        private string $token,
        private string $projectId,
        private TvStrategyInterface $queryStrategy,
        private ?int $limit,
        private ?string $consumerName = self::API_CONSUMER_NAME,
    ) {
    }

    public function generatePersistedQuery(): ApiPersistedQuery
    {
        return new ApiPersistedQuery(
            cacheKey: $this->generateCacheKey(),
            httpMethod: self::V2_DATA_HTTP_METHOD,
            httpUrl: self::V2_JSON_GET_ENDPOINT,
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
            '%s.%s.limit_%s',
            $this->consumerName,
            $this->queryStrategy->getCacheKey(),
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
        $query = [
            'project_id' => $this->projectId,
        ];
        $limit = $this->generateLimit();
        if (null !== $limit) {
            $query['limit'] = $limit;
        }

        return [
            'base_uri' => self::API_URL,
            'headers' => [
                'Cache-Control: no-cache',
                'Content-Type: application/json; charset=utf-8',
                sprintf('User-Id: %d', $this->userId),
                sprintf('Authorization: Bearer %s', $this->token),
            ],
            'query' => $query,
        ];
    }

    private function generateLimit(): ?int
    {
        $this->parametersStrategy instanceof TvParametersStrategyInterface
            ?: throw new YandexMetrikaException("$this->consumerName: query parameters strategy is missing.");

        return $this->limit ?? $this->queryStrategy->getLimit();
    }
}
