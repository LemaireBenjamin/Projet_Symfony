<?php

namespace App\Entity;

use App\Repository\SiteRepository;
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
}
