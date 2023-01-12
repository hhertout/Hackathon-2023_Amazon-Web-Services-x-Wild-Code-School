<?php

namespace App\Service;

use App\Entity\Company;
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
            'https://geocode.search.hereapi.com/v1/geocode',
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

    /*     public function checkDistances(Company $userCompany, array $companies)
    {
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__ . '/../../.env.local');;

        foreach ($companies as $externalCompany) {
            $response = $this->heremapClient->request(
                Request::METHOD_GET,
                'https://router.hereapi.com/v8/routes',
                [
                    'query' => [
                        'transportMode' => 'car',
                        'origin' => $userCompany->getLatitude() . ',' . $userCompany->getLongitude(),
                        'destination' => $externalCompany->getLatitude() . ',' . $externalCompany->getLongitude(),
                        'return' => 'summary',
                        'apikey' => $_ENV['HERE_API_TOKEN']
                    ]
                ]
            );

            $content = $response->toArray();
            $distance = $content['routes'][0]['sections'][0]['summary']['length'] / 1000;

            if ($distance <= 20) {
                $nearCompanies[] = $externalCompany;
            }
        }

        return $externalCompany;
    } */
}
