<?php

namespace App\Services;

use GuzzleHttp\Client;

class PinataService
{
    protected $client;
    protected $pinataApiKey;
    protected $pinataSecretApiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->pinataApiKey = env('PINATA_API_KEY');
        $this->pinataSecretApiKey = env('PINATA_SECRET_API_KEY');
    }

    public function uploadToIPFS($file)
    {
        $tempFilePath = tempnam(sys_get_temp_dir(), 'tempfile');
        file_put_contents($tempFilePath, file_get_contents($file->getPathname()));

        $response = $this->client->post('https://api.pinata.cloud/pinning/pinFileToIPFS', [
            'headers' => [
                'pinata_api_key' => $this->pinataApiKey,
                'pinata_secret_api_key' => $this->pinataSecretApiKey,
            ],
            'multipart' => [
                [
                    'name' => 'file',
                    'contents' => fopen($tempFilePath, 'r'),
                    'filename' => $file->getClientOriginalName(),
                ]
            ]
        ]);

        unlink($tempFilePath);

        $data = json_decode($response->getBody(), true);
        return $data['IpfsHash'];
    }

    public function uploadContentToIPFS($content, $filename)
    {
        $tempFilePath = tempnam(sys_get_temp_dir(), 'tempfile');
        file_put_contents($tempFilePath, $content);

        $response = $this->client->post('https://api.pinata.cloud/pinning/pinFileToIPFS', [
            'headers' => [
                'pinata_api_key' => $this->pinataApiKey,
                'pinata_secret_api_key' => $this->pinataSecretApiKey,
            ],
            'multipart' => [
                [
                    'name' => 'file',
                    'contents' => fopen($tempFilePath, 'r'),
                    'filename' => $filename,
                ]
            ]
        ]);

        unlink($tempFilePath);

        $data = json_decode($response->getBody(), true);
        return $data['IpfsHash'];
    }

    public function deleteIPFS($CID)
    {
        $response = $this->client->delete('https:/api.pinata.cloud/pinning/unpin/' . $CID, [
            'headers' => [
                'pinata_api_key' => $this->pinataApiKey,
                'pinata_secret_api_key' => $this->pinataSecretApiKey,
            ]
        ]);

        return $response->getBody();
    }
}
