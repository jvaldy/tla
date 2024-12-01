<?php

namespace App\Controller;

use App\Service\PredatorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PredatorController extends AbstractController
{
    private $predatorService;

    public function __construct(PredatorService $predatorService)
    {
        $this->predatorService = $predatorService;
    }

    #[Route('/predator', name: 'predator')]
    public function index(): Response
    {
        try {
            $predatorData = $this->predatorService->fetchPredatorData();
        } catch (\Exception $e) {
            return new Response($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        // return $this->json($predatorData);
        return $this->render('predator.html.twig', [
            'predatorData' => $predatorData,
        ]);
    }
}
