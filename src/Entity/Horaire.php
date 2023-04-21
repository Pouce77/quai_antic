<?php

namespace App\Entity;

use App\Repository\HoraireRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HoraireRepository::class)]
class Horaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $day = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $morningStartAt = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $morningEndAt = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $afternoonStartAt = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $afternoonEndAt = null;

    #[ORM\Column]
    private ?int $capacite = null;
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDay(): ?string
    {
        return $this->day;
    }

    public function setDay(string $day): self
    {
        $this->day = $day;

        return $this;
    }

    /**
     * Get the value of morningStartAt
     */ 
    public function getMorningStartAt()
    {
        return $this->morningStartAt;
    }

    /**
     * Set the value of morningStartAt
     *
     * @return  self
     */ 
    public function setMorningStartAt($morningStartAt)
    {
        $this->morningStartAt = $morningStartAt;

        return $this;
    }

    /**
     * Get the value of morningEndAt
     */ 
    public function getMorningEndAt()
    {
        return $this->morningEndAt;
    }

    /**
     * Set the value of morningEndAt
     *
     * @return  self
     */ 
    public function setMorningEndAt($morningEndAt)
    {
        $this->morningEndAt = $morningEndAt;

        return $this;
    }

    /**
     * Get the value of afternoonStartAt
     */ 
    public function getAfternoonStartAt()
    {
        return $this->afternoonStartAt;
    }

    /**
     * Set the value of afternoonStartAt
     *
     * @return  self
     */ 
    public function setAfternoonStartAt($afternoonStartAt)
    {
        $this->afternoonStartAt = $afternoonStartAt;

        return $this;
    }

    /**
     * Get the value of afternoonEndAt
     */ 
    public function getAfternoonEndAt()
    {
        return $this->afternoonEndAt;
    }

    /**
     * Set the value of afternoonEndAt
     *
     * @return  self
     */ 
    public function setAfternoonEndAt($afternoonEndAt)
    {
        $this->afternoonEndAt = $afternoonEndAt;

        return $this;
    }

    public function fractionnerMatin($Duration="60"){
     
        $ReturnArray = array ();
        $start=$this->getMorningStartAt();
        $end=$this->getMorningEndAt();
    
        $timestart=$start->getTimestamp();
        $timeend=$end->getTimestamp();
     
        $AddMins  = $Duration * 15;

        // On enlève la dernière heure
        $timeend = $timeend-($AddMins*4);
     
        while ($timestart <= $timeend)
        {
            $ReturnArray[] = date ("G:i", $timestart);
            $timestart += $AddMins;
        }
        return $ReturnArray;
    }

    public function fractionnerAprem($Duration="60"){
     
        $ReturnArray = array ();
        $start=$this->getAfternoonStartAt();
        $end=$this->getAfternoonEndAt();
    
        $timestart=$start->getTimestamp();
        $timeend=$end->getTimestamp();
     
        $AddMins  = $Duration * 15;
        // On enlève la dernière heure
        $timeend = $timeend-($AddMins*4);

        while ($timestart <= $timeend)
        {
            $ReturnArray[] = date ("G:i", $timestart);
            $timestart += $AddMins;
        }
        
        return $ReturnArray;
    }

    public function getCapacite(): ?int
    {
        return $this->capacite;
    }

    public function setCapacite(int $capacite): self
    {
        $this->capacite = $capacite;

        return $this;
    }
}
