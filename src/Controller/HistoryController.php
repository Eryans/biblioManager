<?php

namespace App\Controller;

use App\Entity\History;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HistoryController extends AbstractController
{
    #[Route('/history', name: 'history')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('history/index.html.twig', [
            'controller_name' => 'HistoryController',
        ]);
    }

    #[Route('/history/listing', name: 'history_listing')]
    public function hystoryFindAll(EntityManagerInterface $doctrine,Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $locale = $request->getLocale();
        if ($locale === "fr") {
            $language = '//cdn.datatables.net/plug-ins/1.11.4/i18n/fr_fr.json';
        } else {
            $language = '//cdn.datatables.net/plug-ins/1.11.4/i18n/en-gb.json';
        }
        $history = $doctrine->getRepository(History::class)->findAll();

        return $this->render('history/listing.html.twig', [
            'controller_name' => 'HistoryController',
            'histories' => $history,
            'language' => $language
        ]);
    }
}
