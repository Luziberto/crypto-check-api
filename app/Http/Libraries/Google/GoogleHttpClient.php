<?php

namespace App\Http\Libraries\Google;

use App\Http\Libraries\GoogleHttpClientFactory;
use App\Util\ClientResponseUtil;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Cache;

class GoogleHttpClient
{
    public static function get(
        string $endpoint,
        array $params = [],
        $credencial,
        array $scopes = [],
    ): ClientResponseUtil {
        return self::request('get', $endpoint, null, $params, $credencial, $scopes);
    }

    public static function post(
        string $endpoint,
        array $body,
        array $params = [],
        array $credencial = [],
        array $scopes = [],
    ): ClientResponseUtil {
        return self::request('post', $endpoint, $body, $params, $credencial, $scopes);
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
        $credencial,
        array $scopes
    ): ClientResponseUtil {
        try {
            $endpoint = self::getBaseUri() . $endpoint;
            $oauthHttpClient = self::oauthHttpClient($credencial, $scopes);
            $response = $oauthHttpClient->$method($endpoint.self::getQueryParams($queryParams), $body ?? []);
            Cache::flush();
            return self::handleResponse($method, $endpoint, $response);
        } catch (RequestException $e) {
            Log::error($e);
            return self::handleRequestError($e);
        }
    }

    public static function getBaseUri()
    {
        return env('GOOGLE_BASE_URL', 'https://www.googleapis.com');
    }

    public static function getQueryParams($params)
    {
        $queryParams = '?';

        foreach ($params as $key => $value) {
            $queryParams .= $key.'='.$value.'&';
        }

        return substr($queryParams, 0, -1);
    }

    public static function httpClient() {
        return GoogleHttpClientFactory::getInstance();
    }

    public static function oauthHttpClient($credencial, $scopes)
    {
        $client = self::httpClient($credencial);
        $client->setAuthConfig($credencial);
        $client = self::addScopes($client, $scopes)->authorize();
        return $client;
    }

    public static function addScopes($client, $scopes) {
        $client->addScope($scopes);
        return $client;
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
