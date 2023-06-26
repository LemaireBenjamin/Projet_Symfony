<?php

namespace App\Entity;

use App\Repository\StatusRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatusRepository::class)]
class Status
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $status_no = null;

    #[ORM\Column]
    private ?int $status_label = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatusNo(): ?int
    {
        return $this->status_no;
    }

    public function setStatusNo(int $status_no): static
    {
        $this->status_no = $status_no;

        return $this;
    }

    public function getStatusLabel(): ?int
    {
        return $this->status_label;
    }

    public function setStatusLabel(int $status_label): static
    {
        $this->status_label = $status_label;

        return $this;
    }
}
