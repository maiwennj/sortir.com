<?php

namespace App\Entity;

use App\Repository\SiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SiteRepository::class)]
class Site
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    #[Assert\Length(min: 3, max: 30, minMessage: 'Le nom du site doit avoir au moins 3 caractères.', maxMessage: 'Le nom du lieu ne doit pas dépasser 30 caractères.')]
    private ?string $siteName = null;

    #[ORM\OneToMany(mappedBy: 'site', targetEntity: Activity::class)]
    private Collection $activities;

    #[ORM\OneToMany(mappedBy: 'site', targetEntity: UserProfile::class, orphanRemoval: true)]
    private Collection $users;

    public function __construct()
    {
        $this->activities = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSiteName(): ?string
    {
        return $this->siteName;
    }

    public function setSiteName(string $siteName): static
    {
        $this->siteName = $siteName;

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

    /**
     * @return Collection<int, UserProfile>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(UserProfile $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setSite($this);
        }

        return $this;
    }

    public function removeUser(UserProfile $user): static
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getSite() === $this) {
                $user->setSite(null);
            }
        }

        return $this;
    }
}
