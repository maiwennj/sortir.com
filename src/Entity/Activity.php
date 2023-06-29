<?php

namespace App\Entity;

use App\Repository\ActivityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActivityRepository::class)]
class Activity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $activityName = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(nullable: true)]
    private ?int $duration = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $closingDate = null;

    #[ORM\Column]
    private ?int $maxRegistration = null;


    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

       #[ORM\Column(length: 250, nullable: true)]
    private ?string $pictureUrl = null;

       #[ORM\ManyToOne(inversedBy: 'activities')]
       #[ORM\JoinColumn(nullable: false)]
       private ?Location $location = null;

       #[ORM\ManyToOne(inversedBy: 'activities')]
       #[ORM\JoinColumn(nullable: false)]
       private ?State $state = null;

       #[ORM\ManyToOne(inversedBy: 'activities')]
       #[ORM\JoinColumn(nullable: false)]
       private ?Site $site = null;

       #[ORM\ManyToOne(inversedBy: 'activities')]
       #[ORM\JoinColumn(nullable: false)]
       private ?UserProfile $organiser = null;

       #[ORM\OneToMany(mappedBy: 'activity', targetEntity: Registration::class, orphanRemoval: true)]
       private Collection $registrations;

       #[ORM\Column(type: Types::TEXT, nullable: true)]
       private ?string $cancellationReason = null;

       public function __construct()
       {
           $this->registrations = new ArrayCollection();
       }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getActivityName(): ?string
    {
        return $this->activityName;
    }

    public function setActivityName(string $activityName): static
    {
        $this->activityName = $activityName;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(?int $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function getClosingDate(): ?\DateTimeInterface
    {
        return $this->closingDate;
    }

    public function setClosingDate(\DateTimeInterface $closingDate): static
    {
        $this->closingDate = $closingDate;

        return $this;
    }

    public function getMaxRegistration(): ?int
    {
        return $this->maxRegistration;
    }

    public function setMaxRegistration(int $maxRegistration): static
    {
        $this->maxRegistration = $maxRegistration;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }


    public function getPictureUrl(): ?string
    {
        return $this->pictureUrl;
    }

    public function setPictureUrl(string $pictureUrl): static
    {
        $this->pictureUrl = $pictureUrl;

        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getState(): ?State
    {
        return $this->state;
    }

    public function setState(?State $state): static
    {
        $this->state = $state;

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

    public function getOrganiser(): ?UserProfile
    {
        return $this->organiser;
    }

    public function setOrganiser(?UserProfile $organiser): static
    {
        $this->organiser = $organiser;

        return $this;
    }

    /**
     * @return Collection<int, Registration>
     */
    public function getRegistrations(): Collection
    {
        return $this->registrations;
    }

    public function addRegistration(Registration $registration): static
    {
        if (!$this->registrations->contains($registration)) {
            $this->registrations->add($registration);
            $registration->setActivity($this);
        }

        return $this;
    }

    public function removeRegistration(Registration $registration): static
    {
        if ($this->registrations->removeElement($registration)) {
            // set the owning side to null (unless already changed)
            if ($registration->getActivity() === $this) {
                $registration->setActivity(null);
            }
        }

        return $this;
    }

    public function getCancellationReason(): ?string
    {
        return $this->cancellationReason;
    }

    public function setCancellationReason(?string $cancellationReason): static
    {
        $this->cancellationReason = $cancellationReason;

        return $this;
    }



}
