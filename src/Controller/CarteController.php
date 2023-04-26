<?php

namespace App\Controller;

use App\Repository\HoraireRepository;
use App\Repository\MenuRepository;
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

    #[Route('/menu', name: 'app_menu')]
    public function menu(HoraireRepository $horaireRepository, MenuRepository $menuRepository): Response
    {
        
        $horaire=$horaireRepository->findAll();
        $menus=$menuRepository->findAll();
        
        // on crée un tableau des titres de menus pour envoyer au template 
        $menuTitle=[];
        foreach ($menus as $value) {
            if(!in_array($value->getTitle(),$menuTitle)){
           array_push($menuTitle,$value->getTitle());
            }
        }

        return $this->render('carte/menus.html.twig', [
            
            'horaires' => $horaire,
            'menus' => $menus,
            'menuTitle'=>$menuTitle
        ]);
    }
}
