<?php

namespace App\Service\API;

use App\Contracts\Service\API\ApiPersistedQueryInterface;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * @todo: check, that execution flow is not interrupted by `trow *Error`.
 */
class ApiConsumerService
{
    /**
     * Boolean value.
     */
    public const OPTION_ALLOW_CACHE = 'allow_cache';
    /**
     * String value, format — [user:pass@]host:port.
     */
    public const OPTION_PROXY_ADDRESS = 'proxy_address';

    private bool $allowCached = true;
    private ?string $proxyAddress = null;

    public function __construct(
        private ?int $cacheTtl,
        private CacheItemPoolInterface $apiConsumerCache,
        private HttpClientInterface $apiConsumerClient,
        private ApiPersistedQueryInterface $apiConcreteConsumer,
    ) {
    }

    public function withOptions(array $options): self
    {
        $this->setAllowCached($options[self::OPTION_ALLOW_CACHE] ?? $this->allowCached);
        $this->setProxyAddress($options[self::OPTION_PROXY_ADDRESS] ?? $this->proxyAddress);

        return $this;
    }

    public function getData(): ?array
    {
        $data = null;
        if ($this->allowCached) {
            $data = $this->getCachedData();
        }

        if (null === $data) {
            $freshData = $this->getFreshData();
        }

        return $data ?? $this->getFreshData();
    }

    private function getCachedData(): ?array
    {
        $cacheKey = $this->apiConcreteConsumer->getCacheKey();
        try {
            $cachedRequest = $this->requestCachePool($cacheKey);
        } catch (\Throwable $e) {
            throw new ApiConsumerServiceException($e->getMessage());
        } finally {
            if (!$cachedRequest->isHit()) {
                return null;
            }
            $cachedData = $cachedRequest->get();
            if (!is_array($cachedData)) {
                throw new ApiConsumerServiceException();
            }

            return $cachedData;
        }
    }

    private function getFreshData(): ?array
    {
        $freshData = null;
        $httpOptions = $this->apiConcreteConsumer->getHttpOptions();
        if (null !== $this->proxyAddress) {
            $httpOptions['proxy'] = $this->proxyAddress;
        }
        try {
            $freshData = $this->apiConsumerClient->request(
                method: $this->apiConcreteConsumer->getHttpMethod(),
                url: $this->apiConcreteConsumer->getHttpUrl(),
                options: $httpOptions,
            )->toArray();
        } catch (\Throwable $e) {
            // todo: create separate handlers to more specific Exceptions?
            throw new ApiConsumerServiceException($e->getMessage());
        } finally {
            $this->saveDataToCache($freshData);

            return $freshData;
        }
    }

    public function setAllowCached(bool $allowCached): self
    {
        $this->allowCached = $allowCached;

        return $this;
    }

    public function setProxyAddress(?string $proxyAddress): self
    {
        $this->proxyAddress = $proxyAddress;
    }

    private function requestCachePool(string $cacheKey): CacheItemInterface
    {
        try {
            $cachedRequest = $this->apiConsumerCache->getItem($cacheKey);
        } catch (InvalidArgumentException $e) {
            throw new ApiConsumerServiceException($e->getMessage());
        }

        return $cachedRequest;
    }

    private function saveDataToCache(array $freshData): self
    {
        $cacheKey = $this->apiConcreteConsumer->getCacheKey();
        try {
            $cachedRequest = $this->requestCachePool($cacheKey);
        } catch (\Throwable $e) {
            throw new ApiConsumerServiceException($e->getMessage());
        } finally {
            $cachedRequest->set($freshData)->expiresAfter($this->cacheTtl);
            $this->apiConsumerCache->save($cachedRequest);
        }

        return $this;
    }
}
