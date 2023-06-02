<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CentralPayService
{
    protected $baseUrl;
    protected $apiKey;
    protected $apiSecret;

    public function __construct()
    {
        $this->baseUrl = 'https://test-api.centralpay.net/v2/rest';
        $this->apiKey = env('CENTRALPAY_API_KEY');
        $this->apiSecret = env('CENTRALPAY_API_SECRET');
    }

    public function createTransaction($params)
    {
        $response = Http::withBasicAuth($this->apiKey, $this->apiSecret)
            ->withHeaders([
                'Origin' => 'https://yourdomain.com',
            ])->asMultipart()
            ->post("{$this->baseUrl}/paymentRequest", $params);

        return $response;
    }
}
