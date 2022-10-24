<?php

namespace App\Http\Libraries\Google\Drive;

use App\Http\Libraries\Google\GoogleHttpClient;
use Google;

class GetFileListRequest
{
    
    public static function get($params, $credencial)
    {
        $endpoint = "/drive/v3/files";

        $scopes = [
            Google\Service\Drive::DRIVE
        ];

        return GoogleHttpClient::get($endpoint, $params, $credencial, $scopes);
    }
}

