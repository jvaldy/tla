<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LicenceController extends AbstractController
{
    #[Route('/licence', name: 'licence')]
    public function index(): Response
    {
        return $this->render('licence.html.twig', [
            'controller_name' => 'LicenceController',
        ]);
    }
}
