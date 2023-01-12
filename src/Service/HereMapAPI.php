<?php

namespace App\Service;

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HereMapAPI
{
    public function __construct(
        private HttpClientInterface $heremapClient,
    ) {
    }

    public function geolocateViaAddress(string $address)
    {
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__ . '/../../.env.local');

        $response = $this->heremapClient->request(
            Request::METHOD_GET,
            '',
            [
                'query' => [
                    'q' => $address,
                    'apiKey' => $_ENV['HERE_API_TOKEN']

                ]
            ]
        );

        $content = $response->toArray();

        return $content['items'][0]['position'];
    }
}
