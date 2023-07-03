<?php

namespace App\Entity;

use App\Repository\ParticipantRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParticipantRepository::class)]
class Participant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'Le nom de famille est requis')]
    #[Assert\Length(max: 50, maxMessage: 'Le nom de famille ne peut pas dépasser {{ limit }} caractères')]
    #[Assert\Regex(pattern: '/^[A-Za-z\- ]+$/', message: 'Le nom de famille n\'est pas valide')]
    private ?string $lastname = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'Le prénom est requis')]
    #[Assert\Length(max: 50, maxMessage: 'Le prénom ne peut pas dépasser {{ limit }} caractères')]
    #[Assert\Regex(pattern: '/^[A-Za-z\- ]+$/', message: 'Le prénom n\'est pas valide')]
    private ?string $firstname = null;

    #[ORM\Column(length: 15, nullable: true)]
    #[Assert\Length(max: 15, maxMessage: 'Le numéro de téléphone ne peut pas dépasser {{ limit }} caractères')]
    #[Assert\Regex(
        pattern: '/^\+?\d+$/',
        message: 'Le numéro de téléphone doit être un nombre positif sans espaces ni caractères spéciaux'
    )]
    private ?string $phone = null;

    #[ORM\Column]
    private ?bool $organiser = null;

    #[ORM\Column]
    private ?bool $active = null;

    #[ORM\ManyToMany(targetEntity: Activity::class, inversedBy: 'participants')]
    private Collection $activities;

    #[ORM\OneToOne(mappedBy: 'participant', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'participants')]
    private ?Site $site = null;

    public function __construct()
    {
        $this->activities = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }


    public function isOrganiser(): ?bool
    {
        return $this->organiser;
    }


    public function setOrganiser(bool $organiser): static
    {
        $this->organiser = $organiser;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    public function getSite(): ?Site
    {
        return $this->site;
    }

    public function setSite(?Site $site): static
    {
        $this->site = $site;

        return $this;
    }

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
//            $activity->setOrganizer($this);
        }

        return $this;
    }

    public function removeActivity(Activity $activity): static
    {
        if ($this->activities->contains($activity)) {
            $this->activities->removeElement($activity);
            // set the owning side to null (unless already changed)
//            if ($activity->getOrganizer() === $this) {
//                $activity->setOrganizer(null);
//            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        // unset the owning side of the relation if necessary
        if ($user === null && $this->user !== null) {
            $this->user->setParticipant(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getParticipant() !== $this) {
            $user->setParticipant($this);
        }

        $this->user = $user;

        return $this;
    }
}
