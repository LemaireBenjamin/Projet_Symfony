<?php

namespace App\Entity;

use App\Repository\InscriptionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InscriptionRepository::class)]
class Inscription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $inscriptionDate = null;

    #[ORM\Column]
    private ?int $activities_activity_no = null;

    #[ORM\Column]
    private ?int $participants_participant_no = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInscriptionDate(): ?\DateTimeInterface
    {
        return $this->inscriptionDate;
    }

    public function setInscriptionDate(\DateTimeInterface $inscriptionDate): static
    {
        $this->inscriptionDate = $inscriptionDate;

        return $this;
    }

    public function getActivitiesActivityNo(): ?int
    {
        return $this->activities_activity_no;
    }

    public function setActivitiesActivityNo(int $activities_activity_no): static
    {
        $this->activities_activity_no = $activities_activity_no;

        return $this;
    }

    public function getParticipantsParticipantNo(): ?int
    {
        return $this->participants_participant_no;
    }

    public function setParticipantsParticipantNo(int $participants_participant_no): static
    {
        $this->participants_participant_no = $participants_participant_no;

        return $this;
    }
}
