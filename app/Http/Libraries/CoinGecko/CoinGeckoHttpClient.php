<?php

namespace App\Http\Libraries\CoinGecko;

use App\Http\Libraries\HttpClientFactory;
use App\Util\ClientResponseUtil;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Psr7\Response;

class CoinGeckoHttpClient
{
    public static function get(
        string $endpoint,
        array $params = [],
        array $header = []
    ): ClientResponseUtil {
        return self::request('GET', $endpoint, null, $params, $header);
    }

    public static function post(
        string $endpoint,
        array $body,
        array $params = [],
        array $header = []
    ): ClientResponseUtil {
        return self::request('POST', $endpoint, $body, $params, $header);
    }

    public static function put(string $endpoint, array $body): ClientResponseUtil
    {
        return self::request('PUT', $endpoint, $body);
    }

    public static function delete(string $endpoint): ClientResponseUtil
    {
        return self::request('DELETE', $endpoint);
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
            $context = self::getRequestOptions($body, $queryParams, $header);
            $response = $client->request($method, $endpoint, $context);
            return self::handleResponse($method, $endpoint, $response);
        } catch (RequestException $e) {
            Log::error($e);
            return self::handleRequestError($e);
        }
    }

    public static function getBaseUri()
    {
        return env('COIN_GECKO_BASE_URL');
    }

    public static function getRequestOptions(
        $data,
        array $queryParams,
        array $headers = null
    ): array {

        $request = [
            'headers' => $headers,
            'query' => $queryParams,
            'json' => $data ?? [],
        ];

        return $request;
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
