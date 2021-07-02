<?php

namespace App\Service\API\TopVisor\V2\Strategy;

use App\Contracts\Service\API\Consumers\TopVisor\TvStrategyInterface;

class TvCustomStrategy implements TvStrategyInterface
{
    private array $arrayData;
    private array $fields;
    private array $filters;
    private array $order;
    private int   $offset;

    public function __construct(
        // private array $queryParameters,
        private string $serviceName,
        private ?string $methodName,
        private ?int $limit,
        private ?string $cacheKey,
    ) {}

    public function getQueryParameters(): array
    {
        $queryParameters = $this->arrayData;
        $queryParameters['fields'] = $this->fields ?? null;
        $queryParameters['filters'] = $this->filters ?? null;
        $queryParameters['orders'] = $this->order ?? null;
        $queryParameters['limit'] = $this->limit ?? null;
        $queryParameters['offset'] = $this->offset ?? null;

        return array_filter($queryParameters);
    }

    public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
     * Cache key MUST follow PHP-FIG 'PSR-6: Caching Interface' standard.
     *
     * @see https://www.php-fig.org/psr/psr-6/ [PSR-6.Definitions.Key] — allowed characters.
     */
    public function getCacheKey(): string
    {
        // TODO: Implement getCacheKey() method.
        $this->cacheKey = $this->cacheKey ?? (new \ReflectionClass($this))->getShortName();

        return sprintf(
            '%s_%s_%s_%s',
            $this->cacheKey,
            $this->serviceName,
            $this->methodName ?? 'undefinedMethod',
            md5(serialize($this->queryParameters)),
        );
    }

    public function setArrayData(array $arrayData): self
    {
        $this->arrayData = $arrayData;

        return $this;
    }

    public function setFields(array $fields): self
    {
        $this->fields = $fields;

        return $this;
    }

    public function setFilters(array $filters): self
    {
        $this->filters = $filters;

        return $this;
    }

    public function setOrder(array $order): self
    {
        $this->order = $order;

        return $this;
    }

    public function setLimit(int $limit): self
    {
        $this->limit = $limit;

        return $this;
    }

    public function setOffset(int $offset): self
    {
        $this->offset = $offset;

        return $this;
    }
}
