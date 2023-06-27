<?php

namespace App\Entity;

use App\Repository\StatusRepository;
<<<<<<< HEAD

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

=======
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
>>>>>>> e490f59b2f0dd452fd8b194253c647a2fc133605
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
    private ?string $status_label = null;

    #[ORM\OneToMany(mappedBy: 'status', targetEntity: Activity::class)]
    private Collection $activities;

    public function __construct()
    {
        $this->activities = new ArrayCollection();
    }

<<<<<<< HEAD

=======
>>>>>>> e490f59b2f0dd452fd8b194253c647a2fc133605
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
            $activity->setStatus($this);
        }

        return $this;
    }

    public function removeActivity(Activity $activity): static
    {
        if ($this->activities->removeElement($activity)) {
            // set the owning side to null (unless already changed)
            if ($activity->getStatus() === $this) {
                $activity->setStatus(null);
            }
        }

        return $this;
    }
<<<<<<< HEAD

=======
>>>>>>> e490f59b2f0dd452fd8b194253c647a2fc133605
}
