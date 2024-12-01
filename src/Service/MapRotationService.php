<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class MapRotationService
{
    private $client;
    private $apiKey;

    public function __construct(HttpClientInterface $client, string $apiKey)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
    }

    public function fetchMapRotation(): array
    {
        $response = $this->client->request('GET', 'https://api.mozambiquehe.re/maprotation', [
            'query' => [
                'version' => 3,
                'auth' => $this->apiKey,
            ],
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new \Exception('Erreur lors de la récupération de la rotation des cartes.');
        }

        return $response->toArray();
    }
}
