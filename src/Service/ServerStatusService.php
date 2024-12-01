<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ServerStatusService
{
    private $client;
    private $apiKey;

    public function __construct(HttpClientInterface $client, string $apiKey)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
    }

    public function fetchServerStatus(): array
    {
        $response = $this->client->request('GET', 'https://api.mozambiquehe.re/servers', [
            'query' => [
                'auth' => $this->apiKey,
            ],
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new \Exception('Erreur lors de la récupération du statut des serveurs.');
        }

        return $response->toArray();
    }
}
