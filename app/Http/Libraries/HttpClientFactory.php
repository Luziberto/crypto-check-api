<?php

namespace App\Http\Libraries;

use GuzzleHttp\Client;

class HttpClientFactory
{

  static function getInstance()
  {
    return new Client();
  }
}
