<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class PredatorService
{
    private $client;
    private $apiKey;

    public function __construct(HttpClientInterface $client, string $apiKey)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
    }

    public function fetchPredatorData(): array
    {
        $response = $this->client->request('GET', 'https://api.mozambiquehe.re/predator', [
            'query' => [
                'auth' => $this->apiKey,
            ],
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new \Exception('Erreur lors de la récupération des données Predator.');
        }

        return $response->toArray();
    }
}
