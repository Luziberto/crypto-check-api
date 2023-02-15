<?php

namespace App\Http\Libraries\CoinGecko;

use App\Http\Libraries\HttpClientFactory;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\Response;

class CoinGeckoHttpClient
{
    public static function get(
        string $endpoint,
        array $params = [],
        array $header = []
    ): Response {
        return self::request('get', $endpoint, null, $params, $header);
    }

    public static function post(
        string $endpoint,
        array $body,
        array $params = [],
        array $header = []
    ): Response {
        return self::request('post', $endpoint, $body, $params, $header);
    }

    public static function put(string $endpoint, array $body): Response
    {
        return self::request('put', $endpoint, $body);
    }

    public static function delete(string $endpoint): Response
    {
        return self::request('delete', $endpoint);
    }

    public static function request(
        string $method,
        string $endpoint,
        array $body = null,
        array $queryParams = [],
        array $header = []
    ): Response {
        $endpoint = self::getBaseUri() . $endpoint;
        $client = HttpClientFactory::getInstance();
        $response = $client::withHeaders($header)->$method($endpoint, $body ?? $queryParams);
        $response->throw();
        return $response;
    }

    public static function getBaseUri()
    {
        return env('COIN_GECKO_BASE_URL', 'https://api.coingecko.com/api/v3');
    }
}
