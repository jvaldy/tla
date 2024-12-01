<?php

namespace App\Controller;

use App\Service\ServerStatusService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServerController extends AbstractController
{
    private $serverStatusService;

    public function __construct(ServerStatusService $serverStatusService)
    {
        $this->serverStatusService = $serverStatusService;
    }

    #[Route('/server', name: 'server')]
    public function index(): Response
    {
        try {
            $serverStatus = $this->serverStatusService->fetchServerStatus();
        } catch (\Exception $e) {
            return new Response($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->render('server.html.twig', [
            'serverStatus' => $serverStatus,
        ]);
    }
}
