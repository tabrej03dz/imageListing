<?php

namespace App\Services;

use GuzzleHttp\Client;

class WhatsappApiService{

    protected $client;
    public function __construct(){
        $this->client = new Client([
            'base_url' => 'https://rvgwp.in/api'
        ]);
    }
}
