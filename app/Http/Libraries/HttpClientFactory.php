<?php

namespace App\Http\Libraries;

use Illuminate\Support\Facades\Http;


class HttpClientFactory
{

  static function getInstance()
  {
    return new Http();
  }
}
