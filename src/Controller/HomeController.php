<?php

namespace App\Controller;

use App\Repository\HoraireRepository;
use App\Repository\ImagePlatsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ImagePlatsRepository $imagePlatsRepository, HoraireRepository $horaireRepository): Response
    {
        $images=$imagePlatsRepository->findAll();
        $horaires=$horaireRepository->findAll();

        return $this->render('home/index.html.twig', [
            'images' => $images,
            'horaires' => $horaires
        ]);
    }
}
