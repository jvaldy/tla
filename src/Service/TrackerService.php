<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class TrackerService
{
    private $client;
    private $apiKey;

    public function __construct(HttpClientInterface $client, string $apiKey)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
    }

    public function getPlayerData(string $platform, string $pseudo): array
    {
        $response = $this->client->request('GET', "https://api.mozambiquehe.re/bridge", [
            'query' => [
                'version' => 5,
                'platform' => $platform,
                'player' => $pseudo,
                'auth' => $this->apiKey,
            ],
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new \Exception('Erreur lors de la récupération des données du joueur.');
        }

        return $response->toArray();
    }
}
