<?php

namespace App\Controller;

use App\Repository\HoraireRepository;
use App\Repository\PlatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarteController extends AbstractController
{
    #[Route('/carte', name: 'app_carte')]
    public function index(PlatRepository $platRepository, HoraireRepository $horaireRepository): Response
    {
        $entrees=$platRepository->findByCategory("Entrées");
        $plats=$platRepository->findByCategory("Plats");
        $desserts=$platRepository->findByCategory("Desserts");
        
        $horaire=$horaireRepository->findAll();

        return $this->render('carte/index.html.twig', [
            'entrees' => $entrees,
            'plats' => $plats,
            'desserts' => $desserts,
            'horaires' => $horaire
        ]);
    }
}
