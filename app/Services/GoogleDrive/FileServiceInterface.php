<?php

namespace App\Services\GoogleDrive;

interface FileServiceInterface {
    public function list(): array;
}