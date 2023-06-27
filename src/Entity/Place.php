<?php

namespace App\Entity;

use App\Repository\PlaceRepository;
<<<<<<< HEAD

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

=======
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
>>>>>>> e490f59b2f0dd452fd8b194253c647a2fc133605
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlaceRepository::class)]
class Place
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $place_id = null;

    #[ORM\Column(length: 50)]
    private ?string $place_name = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $place_street = null;

    #[ORM\Column(nullable: true)]
    private ?float $latitude = null;

    #[ORM\Column(nullable: true)]
    private ?float $longitude = null;

    #[ORM\OneToMany(mappedBy: 'place', targetEntity: Activity::class)]
    private Collection $activities;

    #[ORM\ManyToOne(inversedBy: 'places')]
    private ?City $city = null;

    public function __construct()
    {
        $this->activities = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlaceId(): ?int
    {
        return $this->place_id;
    }

    public function setPlaceId(int $place_id): static
    {
        $this->place_id = $place_id;

        return $this;
    }

    public function getPlaceName(): ?string
    {
        return $this->place_name;
    }

    public function setPlaceName(string $place_name): static
    {
        $this->place_name = $place_name;

        return $this;
    }

    public function getPlaceStreet(): ?string
    {
        return $this->place_street;
    }

    public function setPlaceStreet(?string $place_street): static
    {
        $this->place_street = $place_street;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }
<<<<<<< HEAD

=======
>>>>>>> e490f59b2f0dd452fd8b194253c647a2fc133605

    /**
     * @return Collection<int, Activity>
     */
    public function getActivities(): Collection
    {
        return $this->activities;
    }

    public function addActivity(Activity $activity): static
    {
        if (!$this->activities->contains($activity)) {
            $this->activities->add($activity);
            $activity->setPlace($this);
        }

        return $this;
    }

    public function removeActivity(Activity $activity): static
    {
        if ($this->activities->removeElement($activity)) {
            // set the owning side to null (unless already changed)
            if ($activity->getPlace() === $this) {
                $activity->setPlace(null);
            }
        }

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): static
    {
        $this->city = $city;

        return $this;
    }
<<<<<<< HEAD

=======
>>>>>>> e490f59b2f0dd452fd8b194253c647a2fc133605
}
