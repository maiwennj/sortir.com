<?php

namespace App\Entity;

use App\Repository\UserProfileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserProfileRepository::class)]
class UserProfile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
//    #[Assert\Length(min: 1,minMessage: 'Le nom de famille ne peut pas être vide.')]
    private ?string $lastName = null;

    #[ORM\Column(length: 30)]
    private ?string $firstName = null;

    #[ORM\Column(length: 15, nullable: true)]
    private ?string $phoneNumber = null;

    #[ORM\Column(length: 50)]
    private ?string $emailAdress = null;

    #[ORM\OneToMany(mappedBy: 'organiser', targetEntity: Activity::class, orphanRemoval: true)]
    private Collection $organisedActivities;



    #[ORM\ManyToOne(inversedBy: 'users')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Site $site = null;

    #[ORM\OneToMany(mappedBy: 'participant', targetEntity: Registration::class, orphanRemoval: true)]
    private Collection $registrations;

    #[ORM\OneToOne(inversedBy: 'userProfile',cascade: ['persist', 'remove'])]
    private ?User $user = null;

    public function __construct()
    {
        $this->organisedActivities = new ArrayCollection();
        $this->registrations = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getEmailAdress(): ?string
    {
        return $this->emailAdress;
    }

    public function setEmailAdress(string $emailAdress): static
    {
        $this->emailAdress = $emailAdress;

        return $this;
    }


    /**
     * @return Collection<int, Activity>
     */
    public function getOrganisedActivities(): Collection
    {
        return $this->organisedActivities;
    }

    public function addActivity(Activity $activity): static
    {
        if (!$this->organisedActivities->contains($activity)) {
            $this->organisedActivities->add($activity);
            $activity->setOrganiser($this);
        }

        return $this;
    }

    public function removeActivity(Activity $activity): static
    {
        if ($this->organisedActivities->removeElement($activity)) {
            // set the owning side to null (unless already changed)
            if ($activity->getOrganiser() === $this) {
                $activity->setOrganiser(null);
            }
        }

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
            $registration->setParticipant($this);
        }

        return $this;
    }

    public function removeRegistration(Registration $registration): static
    {
        if ($this->registrations->removeElement($registration)) {
            // set the owning side to null (unless already changed)
            if ($registration->getParticipant() === $this) {
                $registration->setParticipant(null);
            }
        }

        return $this;
    }


    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }


}
