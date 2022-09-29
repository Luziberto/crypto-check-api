<?php

namespace App\Util;

class ClientResponseUtil
{
    const NONE = 'NONE';
    const SUCCESS = 'SUCCESS';
    const ERROR = 'ERROR';

    private $status = self::NONE;
    public $data;
    public $error;
    public $contentData;

    private function __construct($data, $status, $contentData = '')
    {
        $this->data = $data;
        $this->status = $status;
        $this->contentData = $contentData;
    }

    public function isSuccessful()
    {
        return $this->status === self::SUCCESS;
    }

    public function isFailure()
    {
        return $this->status === self::ERROR;
    }

    public static function success($data)
    {
        return new ClientResponseUtil($data, self::SUCCESS);
    }

    public static function error($data, $contentData = '')
    {
        return new ClientResponseUtil($data, self::ERROR, $contentData);
    }
}
