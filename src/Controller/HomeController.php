<?php

namespace App\Controller;

use App\Service\ApexNewsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $apexNewsService;

    public function __construct(ApexNewsService $apexNewsService)
    {
        $this->apexNewsService = $apexNewsService;
    }

    #[Route('/', name: 'home')]
    public function index(): Response
    {
        try {
            // Obtenir les trois dernières actualités
            $news = $this->apexNewsService->fetchNews();
            $latestNews = array_slice($news, 0, 3); // Obtenez les trois premiers éléments
        } catch (\Exception $e) {
            return new Response('Erreur : ' . $e->getMessage(), 500);
        }

        return $this->render('home.html.twig', [
            'latestNews' => $latestNews,
        ]);
    }
}
