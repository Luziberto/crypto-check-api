<?php

namespace App\Http\Libraries\CoinGecko;

use App\Http\Libraries\HttpClientFactory;
use App\Util\ClientResponseUtil;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;

class CoinGeckoHttpClient
{
    public static function get(
        string $endpoint,
        array $params = [],
        array $header = []
    ): ClientResponseUtil {
        return self::request('get', $endpoint, null, $params, $header);
    }

    public static function post(
        string $endpoint,
        array $body,
        array $params = [],
        array $header = []
    ): ClientResponseUtil {
        return self::request('post', $endpoint, $body, $params, $header);
    }

    public static function put(string $endpoint, array $body): ClientResponseUtil
    {
        return self::request('put', $endpoint, $body);
    }

    public static function delete(string $endpoint): ClientResponseUtil
    {
        return self::request('delete', $endpoint);
    }

    public static function request(
        string $method,
        string $endpoint,
        array $body = null,
        array $queryParams = [],
        array $header = []
    ): ClientResponseUtil {
        try {
            $endpoint = self::getBaseUri() . $endpoint;
            $client = HttpClientFactory::getInstance();
            $response = $client::withHeaders($header)->$method($endpoint, $body ?? $queryParams);
            return self::handleResponse($method, $endpoint, $response);
        } catch (RequestException $e) {
            Log::error($e);
            return self::handleRequestError($e);
        }
    }

    public static function getBaseUri()
    {
        return env('COIN_GECKO_BASE_URL', 'https://api.coingecko.com/api/v3');
    }

    public static function handleResponse(string $method, string $endpoint, Response $response)
    {
        return ClientResponseUtil::success(collect(json_decode($response->getBody(), true)));
    }

    public static function handleRequestError(RequestException $err)
    {
        $response = $err->getResponse();
        $body = '';
        $contentBody = '';

        if ($response) {
            $contentBody = $response->getBody()->getContents();
            $body = json_decode($response->getBody(), true);
        }

        return ClientResponseUtil::error($body, $contentBody);
    }
}
