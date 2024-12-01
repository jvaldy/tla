<?php

namespace App\Controller;

use App\Service\MapRotationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MapController extends AbstractController
{
    private $mapRotationService;

    public function __construct(MapRotationService $mapRotationService)
    {
        $this->mapRotationService = $mapRotationService;
    }

    #[Route('/maps', name: 'maps')]
    public function index(): Response
    {
        try {
            $mapData = $this->mapRotationService->fetchMapRotation();
        } catch (\Exception $e) {
            return new Response('Erreur : ' . $e->getMessage(), 500);
        }

        return $this->render('maps.html.twig', [
            'mapData' => $mapData,
        ]);
    }
}
