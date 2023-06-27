<?php

namespace App\Entity;

use App\Repository\SiteRepository;
<<<<<<< HEAD

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

=======
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
>>>>>>> e490f59b2f0dd452fd8b194253c647a2fc133605
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
>>>>>>> e490f59b2f0dd452fd8b194253c647a2fc133605
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
>>>>>>> e490f59b2f0dd452fd8b194253c647a2fc133605

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
>>>>>>> e490f59b2f0dd452fd8b194253c647a2fc133605
}
