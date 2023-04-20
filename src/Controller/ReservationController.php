<?php

namespace App\Controller;

use App\Entity\Horaire;
use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\HoraireRepository;
use App\Repository\ReservationRepository;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ReservationController extends AbstractController
{

    #[Route('/reservation', name: 'app_reservation')]
    public function index(ReservationRepository $reservationRepository, Request $request, HoraireRepository $horaireRepository, ManagerRegistry $doctrine): Response
    {
        $horaire=new Horaire();
        $horaires=$horaireRepository->findAll();

        // on récupère le jour de la semaine
        $day=$request->query->get('reservationDay');
        $dayDatetime=strtotime($day);
        dump($dayDatetime);
        $dayReservation=new DateTime($day);
        $dayFormat=date("D", strtotime($day));
        $jour=getDay($dayFormat);

        //on boucle pour récupérer tous les horaires possible le jour choisi
        foreach($horaires as $hor){

            if($jour==$hor->getDay()){
                $horaire=$hor;
            }

        }

        // Créneaux du matin et de l'aprés midi en fonction du jour de la semaine
        $creneauxMatin=$horaire->fractionnerMatin();
        $creneauxAprem=$horaire->fractionnerAprem();

        //Tableau des créneaux indisponibles
        $reservations=$reservationRepository->findByDay($day);
        $crenauxIndisponibles=array();
            foreach ($reservations as $reservation) {
                $creneau=$reservation->getCreneaux();
                array_push($crenauxIndisponibles,$creneau);
            }
            
        $reservation=new Reservation();
        $form=$this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {    
            $reservation->setDay($dayReservation);
            $entityManager=$doctrine->getManager();
            $entityManager->persist($reservation);
            $entityManager->flush();
            return $this->redirectToRoute('app_home');
        }
        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservations,
            'form' => $form->createView(),
            'day' => $day,
            'creneauxMatin' => $creneauxMatin,
            'creneauxAprem'=> $creneauxAprem,
            'creneauxIndisponibles' => $crenauxIndisponibles
        ]);
    }

    
}

// récupération des jours en français
function getDay($day){
    $jourSemaine=["Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi","Dimanche"];
    $dayofWeek=["Mon","Tue","Wed","Thu","Fri","Sat","Sun"];

    for($i=0,$size = count($dayofWeek); $i < $size;$i++){
    
        if($dayofWeek[$i]==$day){
            
           $jour=$jourSemaine[$i];    
           return $jour;
        }

    };
}


