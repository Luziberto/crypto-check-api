<?php

namespace App\Http\Libraries;

use Google;

class GoogleHttpClientFactory
{

  static function getInstance()
  {
    return new Google\Client();
  }
}
