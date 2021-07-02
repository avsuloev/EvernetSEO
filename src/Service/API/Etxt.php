<?php

namespace App\Service\API;

use Psr\Log\LoggerInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Etxt
{
    private const API_BASE = 'https://www.etxt.ru/api';
    private const API_FORMAT = 'json';
    private const API_URL = self::API_BASE.'/'.self::API_FORMAT.'/';
    private string $logName;
    private HttpClientInterface $client;

    public function __construct(
        private int $cacheTtl,
        private LoggerInterface $logger,
        private CacheInterface $appCache,
        HttpClientInterface $client,
    ) {
        $this->logName = (new \ReflectionClass($this))->getShortName();
        $this->client = $client->withOptions([
            'base_uri' => self::API_URL,
            'headers' => [
                '',
            ],
        ]);
    }
}
