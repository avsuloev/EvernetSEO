<?php

namespace App\Service\API;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiHttpClient
{
    private const YM_BASE_URI = 'https://api-metrika.yandex.net';
    private const YM_DATA_ENDPOINT_URL = '/stat/v1/data';

    public function __construct(
        private string $token,
        private HttpClientInterface $client,
        private ?string $proxyServer,
    ) {}

    public function getApiClient(

        string $token,
        ?string $proxyServer,
    ): HttpClientInterface {

    }

    /**
     * HttpClient for Etxt API requests.
     */
    public function getEtxtClient(): HttpClientInterface
    {
        return $this->client;
    }

    /**
     * HttpClient for GoGetLinks API requests.
     */
    public function getGglClient(): HttpClientInterface
    {
        return $this->client;
    }

    /**
     * HttpClient for TopVisor API requests.
     */
    public function getTvClient(): HttpClientInterface
    {
        return $this->client;
    }

    /**
     * HttpClient for YandexMetrika API requests.
     */
    public function getYmClient(): HttpClientInterface
    {
        $options = [
            'base_uri' => self::YM_BASE_URI,
            'headers' => [
                'Content-Type' => 'application/x-yametrika+json',
                'Authorization' => "OAuth $this->token",
            ],
        ];
        if (null !== $this->proxyServer) {
            $options['proxy'] = $this->proxyServer;
        }

        return $this->client::withOptions($options);
    }
}
