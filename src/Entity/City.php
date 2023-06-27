<?php

namespace App\Entity;

use App\Repository\CityRepository;
<<<<<<< HEAD
=======
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
>>>>>>> 5b8d79f142dbba5058a1c2b42ebdc47c14c8e179
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

<<<<<<< HEAD
=======
    #[ORM\OneToMany(mappedBy: 'city', targetEntity: Place::class)]
    private Collection $places;

    public function __construct()
    {
        $this->places = new ArrayCollection();
    }

>>>>>>> 5b8d79f142dbba5058a1c2b42ebdc47c14c8e179
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
<<<<<<< HEAD
=======

    /**
     * @return Collection<int, Place>
     */
    public function getPlaces(): Collection
    {
        return $this->places;
    }

    public function addPlace(Place $place): static
    {
        if (!$this->places->contains($place)) {
            $this->places->add($place);
            $place->setCity($this);
        }

        return $this;
    }

    public function removePlace(Place $place): static
    {
        if ($this->places->removeElement($place)) {
            // set the owning side to null (unless already changed)
            if ($place->getCity() === $this) {
                $place->setCity(null);
            }
        }

        return $this;
    }
>>>>>>> 5b8d79f142dbba5058a1c2b42ebdc47c14c8e179
}
