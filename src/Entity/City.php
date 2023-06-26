<?php

namespace App\Entity;

use App\Repository\CityRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CityRepository::class)]
class City
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $city_no = null;

    #[ORM\Column(length: 30)]
    private ?string $city_name = null;

    #[ORM\Column(length: 10)]
    private ?string $zipcode = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCityNo(): ?int
    {
        return $this->city_no;
    }

    public function setCityNo(int $city_no): static
    {
        $this->city_no = $city_no;

        return $this;
    }

    public function getCityName(): ?string
    {
        return $this->city_name;
    }

    public function setCityName(string $city_name): static
    {
        $this->city_name = $city_name;

        return $this;
    }

    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    public function setZipcode(string $zipcode): static
    {
        $this->zipcode = $zipcode;

        return $this;
    }
}
