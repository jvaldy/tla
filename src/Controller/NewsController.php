<?php

namespace App\Controller;

use App\Service\ApexNewsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends AbstractController
{
    private $apexNewsService;

    public function __construct(ApexNewsService $apexNewsService)
    {
        $this->apexNewsService = $apexNewsService;
    }

    #[Route('/news', name: 'news')]
    public function index(): Response
    {
        try {
            $news = $this->apexNewsService->fetchNews();
        } catch (\Exception $e) {
            return new Response('Erreur : ' . $e->getMessage(), 500);
        }

        return $this->render('news.html.twig', [
            'news' => $news,
        ]);
    }
}
