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

    #[ORM\Column(length: 30)]
    private ?string $nameSite = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameSite(): ?string
    {
        return $this->nameSite;
    }

    public function setNameSite(string $nameSite): static
    {
        $this->nameSite = $nameSite;

        return $this;
    }
}
