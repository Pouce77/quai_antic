<?php

namespace App\Controller;

use App\Entity\Horaire;
use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\HoraireRepository;
use App\Repository\ReservationRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{

    #[Route('/reservation', name: 'app_reservation')]
    public function index(Request $request, HoraireRepository $horaireRepository, ManagerRegistry $doctrine): Response
    {
        $horaire=new Horaire();
        $horaires=$horaireRepository->findAll();

        $reservation=new Reservation();
        $form=$this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {                
            $entityManager=$doctrine->getManager();
            $entityManager->persist($reservation);
            $entityManager->flush();

            return $this->render('reservation/confirm.html.twig', [
                'confirm' => true,
                'day' => $reservation->getDay(),
                'horaire' => $reservation->getCreneaux(),
                'nbrPersonne' => $reservation->getNumberOfpeople(),
                'horaires' => $horaires
            ]);
        }
        return $this->render('reservation/index.html.twig', [
            'form' => $form->createView(),
            'horaires' => $horaires
         ]);
    }

    #[Route('/reservation/{day}', name: 'app_reservation_day')]
    public function reservation(String $day, HoraireRepository $horaireRepository, ReservationRepository $reservationRepository): Response
    {
        $horaires=$horaireRepository->findAll();
        $horaire=new Horaire();

        $dayFormat=date("D", strtotime($day));
        $jour=getDay($dayFormat);

        foreach($horaires as $hor){
            if($jour==$hor->getDay()){
               $horaire=$hor;
            }
        };

        $creneauMatin=$horaire->fractionnerMatin();
        $creneauSoir=$horaire->fractionnerAprem();

        $ferme=false;
        if($horaire->getCapacite()==0){
            $ferme=true;
        }

        //On vérifie si le restaurant est complet 
        
        $reservations=$reservationRepository->findByDay($day);
        $completM=false;
        $capaciteMatin=getCapaciteMatin($reservations,$creneauMatin);
        if($horaire->getCapacite() <= $capaciteMatin){
            $completM=true;
        } 
        $completA=false;
        $capaciteAprem=getCapaciteAprem($reservations,$creneauSoir);
        if($horaire->getCapacite() <= $capaciteAprem){
            $completA=true;
        }

        //Tableau des créneaux indisponibles
        $crenauxIndisponibles=array();
            foreach ($reservations as $reservation) {
                $creneau=$reservation->getCreneaux();
                array_push($crenauxIndisponibles,$creneau);
            }
        foreach ($crenauxIndisponibles as $creneau){
            if(in_array($creneau,$creneauMatin)){
                unset($creneauMatin[array_search($creneau, $creneauMatin)]);
            }
            if(in_array($creneau,$creneauSoir)){
                unset($creneauMatin[array_search($creneau, $creneauSoir)]);
            }

        }

        $donnees=[
            'creneauxMatin' => $creneauMatin,
            'creneauxAprem'=> $creneauSoir,
            'completM' => $completM,
            'completA' => $completA,
            'ferme' => $ferme
        ];    
        
        return $this->json($donnees);
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

//récupération de la capacité du restaurant en fonction du matin ou du soir
function getCapaciteMatin($reservations, $creneauxMatin):int
{
    $capacite=0;
    
    foreach($reservations as $reservation){
        if(in_array($reservation->getCreneaux(),$creneauxMatin)){
        $capacite+=$reservation->getNumberOfpeople();
        }
    }

    return $capacite;
}
function getCapaciteAprem($reservations, $creneauxAprem):int
{
    $capacite=0;
    
    foreach($reservations as $reservation){
        if(in_array($reservation->getCreneaux(),$creneauxAprem)){
        $capacite+=$reservation->getNumberOfpeople();
        }
    }

    return $capacite;
}


