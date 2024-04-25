<?php

namespace App\Entity;

use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeamRepository::class)]
class Team
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $crest = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $website = null;

    #[ORM\Column(nullable: true)]
    private ?int $founded = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $colors = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $venue = null;

    /**
     * @var Collection<int, Player>
     */
    #[ORM\OneToMany(targetEntity: Player::class, mappedBy: 'team')]
    private Collection $squad;

    #[ORM\OneToOne(inversedBy: 'team', cascade: ['persist', 'remove'])]
    private ?Coach $coach = null;

    #[ORM\Column]
    private ?int $externalId = null;

    public function __construct()
    {
        $this->squad = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCrest(): ?string
    {
        return $this->crest;
    }

    public function setCrest(?string $crest): static
    {
        $this->crest = $crest;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): static
    {
        $this->website = $website;

        return $this;
    }

    public function getFounded(): ?int
    {
        return $this->founded;
    }

    public function setFounded(?int $founded): static
    {
        $this->founded = $founded;

        return $this;
    }

    public function getColors(): ?string
    {
        return $this->colors;
    }

    public function setColors(?string $colors): static
    {
        $this->colors = $colors;

        return $this;
    }

    public function getVenue(): ?string
    {
        return $this->venue;
    }

    public function setVenue(?string $venue): static
    {
        $this->venue = $venue;

        return $this;
    }

    /**
     * @return Collection<int, Player>
     */
    public function getSquad(): Collection
    {
        return $this->squad;
    }

    public function addSquad(Player $squad): static
    {
        if (!$this->squad->contains($squad)) {
            $this->squad->add($squad);
            $squad->setTeam($this);
        }

        return $this;
    }

    public function removeSquad(Player $squad): static
    {
        if ($this->squad->removeElement($squad)) {
            // set the owning side to null (unless already changed)
            if ($squad->getTeam() === $this) {
                $squad->setTeam(null);
            }
        }

        return $this;
    }

    public function getCoach(): ?Coach
    {
        return $this->coach;
    }

    public function setCoach(?Coach $coach): static
    {
        $this->coach = $coach;

        return $this;
    }

    public function getExternalId(): ?int
    {
        return $this->externalId;
    }

    public function setExternalId(int $externalId): static
    {
        $this->externalId = $externalId;

        return $this;
    }
}
