<?php

namespace App\Controller;

use App\Form\TrackerFormType;
use App\Service\TrackerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Dompdf\Dompdf;
use Dompdf\Options;

class TrackerController extends AbstractController
{
    private $trackerService;

    public function __construct(TrackerService $trackerService)
    {
        $this->trackerService = $trackerService;
    }

    #[Route('/tracker', name: 'tracker')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(TrackerFormType::class);
        $form->handleRequest($request);

        $playerData = null;
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $pseudo = $data['pseudo'];
            $platform = $data['platform'];

            try {
                $playerData = $this->trackerService->getPlayerData($platform, $pseudo);
            } catch (\Exception $e) {
                $this->addFlash('error', 'Erreur lors de la récupération des données.');
            }
        }

        return $this->render('tracker.html.twig', [
            'form' => $form->createView(),
            'playerData' => $playerData,
        ]);
    }













    #[Route('/tracker-dl-pdf', name: 'tracker-dl-pdf')]
    public function downloadPdf(Request $request): Response
    {
        $pseudo = $request->query->get('pseudo');
        $platform = $request->query->get('platform');

        if (!$pseudo || !$platform) {
            $this->addFlash('error', 'Pseudo ou plateforme manquant.');
            return $this->redirectToRoute('tracker');
        }

        try {
            $playerData = $this->trackerService->getPlayerData($platform, $pseudo);
        } catch (\Exception $e) {
            $this->addFlash('error', 'Erreur lors de la récupération des données.');
            return $this->redirectToRoute('tracker');
        }


     
        


        // Configure Dompdf
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // $pdfOptions->set('isRemoteEnabled', true); // Autorise le chargement des ressources distantes

        // Instantiate Dompdf with options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML of the page
        $html = $this->renderView('pdf.html.twig', [
            'playerData' => $playerData, // Passer playerData à la vue
        ]);

        // Load HTML into Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Set paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("Traqueur_Legendes_Apex.pdf", [
            "Attachment" => true
        ]);

        return new Response();
    }








}
