<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\HoraireRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user/new', name: 'app_user_new')]
    public function new(Request $request,UserPasswordHasherInterface $userPasswordHasher, ManagerRegistry $doctrine, HoraireRepository $horaireRepository): Response
    {
        $user=new User($userPasswordHasher);
        $horaires=$horaireRepository->findAll();

        $form=$this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {    
            $entityManager=$doctrine->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('login');
        }

        return $this->render('user/form.html.twig', [
            "form" => $form->createView(),
            "horaires"=>$horaires
        ]);
    }
}
