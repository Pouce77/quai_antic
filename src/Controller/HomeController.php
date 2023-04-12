<?php

namespace App\Controller;

use App\Repository\ImagePlatsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(ImagePlatsRepository $imagePlatsRepository): Response
    {
        $images=$imagePlatsRepository->findAll();

        return $this->render('home/index.html.twig', [
            'images' => $images,
        ]);
    }
}
