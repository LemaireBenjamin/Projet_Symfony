<?php

namespace App\Entity;

use App\Repository\SiteRepository;
<<<<<<< HEAD
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
=======

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

>>>>>>> 4a6dbdb9c650f4fcb8c0fd74ec7e8193426e9e8e
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SiteRepository::class)]
class Site
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $site_no = null;

    #[ORM\Column(length: 30)]
    private ?string $site_name = null;

<<<<<<< HEAD
=======

>>>>>>> 4a6dbdb9c650f4fcb8c0fd74ec7e8193426e9e8e
    #[ORM\OneToMany(mappedBy: 'site', targetEntity: Participant::class)]
    private Collection $participants;

    #[ORM\OneToMany(mappedBy: 'site', targetEntity: Activity::class)]
    private Collection $activities;

    public function __construct()
    {
        $this->participants = new ArrayCollection();
        $this->activities = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSiteNo(): ?int
    {
        return $this->site_no;
    }

    public function setSiteNo(int $site_no): static
    {
        $this->site_no = $site_no;

        return $this;
    }

    public function getSiteName(): ?string
    {
        return $this->site_name;
    }

    public function setSiteName(string $site_name): static
    {
        $this->site_name = $site_name;

        return $this;
    }
<<<<<<< HEAD
=======

>>>>>>> 4a6dbdb9c650f4fcb8c0fd74ec7e8193426e9e8e

    /**
     * @return Collection<int, Participant>
     */
    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    public function addParticipant(Participant $participant): static
    {
        if (!$this->participants->contains($participant)) {
            $this->participants->add($participant);
            $participant->setSite($this);
        }

        return $this;
    }

    public function removeParticipant(Participant $participant): static
    {
        if ($this->participants->removeElement($participant)) {
            // set the owning side to null (unless already changed)
            if ($participant->getSite() === $this) {
                $participant->setSite(null);
            }
        }

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
            $activity->setSite($this);
        }

        return $this;
    }

    public function removeActivity(Activity $activity): static
    {
        if ($this->activities->removeElement($activity)) {
            // set the owning side to null (unless already changed)
            if ($activity->getSite() === $this) {
                $activity->setSite(null);
            }
        }

        return $this;
    }
<<<<<<< HEAD
=======

>>>>>>> 4a6dbdb9c650f4fcb8c0fd74ec7e8193426e9e8e
}
