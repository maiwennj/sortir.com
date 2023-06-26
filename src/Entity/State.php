<?php

namespace App\Entity;

use App\Repository\StateRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StateRepository::class)]
class State
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(length: 30)]
    private ?string $label = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNoState(): ?int
    {
        return $this->noState;
    }

    public function setNoState(int $noState): static
    {
        $this->noState = $noState;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }
}
