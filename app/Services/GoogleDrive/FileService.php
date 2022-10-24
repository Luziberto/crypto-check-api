<?php
    
namespace App\Services\GoogleDrive;

use App\Http\Libraries\Google\Drive\GetFileListRequest;
use App\Services\GoogleDrive\FileServiceInterface;

use Google;

class FileService implements FileServiceInterface {

    public $httpClient;

    private function getCredencial() {
        $key_file_location = storage_path().'/app/credencials/google-drive-asset-app.json';
        $key = file_get_contents($key_file_location);
        return json_decode($key, true);
    }

    public function list(): array {
        $assetsData = [];
        $files = [];
        do {
            $pageToken = $responseData['nextPageToken'] ?? null;
            
            $params = [
                'pageSize' => 1000,
                'pageToken' => $pageToken,
                'fields' => 'nextPageToken, files/name,files/webContentLink',
            ];

            $responseData = GetFileListRequest::get($params, $this->getCredencial())->data;
            $assetsData = array_merge($assetsData, $responseData['files']);
        } while (count($responseData['files']) === 1000);

        $files = [];

        foreach ($assetsData as $key => $value) {
            $files[str_replace('.png', '', $value['name'])] = isset($value['webContentLink']) ? $value['webContentLink'] : null;
        }

        return $files;
    }
}