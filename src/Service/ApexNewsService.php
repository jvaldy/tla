<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApexNewsService
{
    private $client;
    private $apiKey;

    public function __construct(HttpClientInterface $client, string $apiKey)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
    }

    public function fetchNews(string $lang = 'fr'): array
    {
        $response = $this->client->request('GET', 'https://api.mozambiquehe.re/news', [
            'query' => [
                'auth' => $this->apiKey,
                'lang' => $lang,
            ],
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new \Exception('Erreur lors de la récupération des actualités.');
        }

        // return $response->toArray();
        $news = $response->toArray();

        // Décodage des entités HTML
        foreach ($news as &$article) {
            $article['title'] = html_entity_decode($article['title'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $article['short_desc'] = html_entity_decode($article['short_desc'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        }

        return $news;
    }
}
