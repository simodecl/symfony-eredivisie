<?php

namespace App\Entity;

use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Defines the properties of the Team entity to represent the teams.
 */
#[ORM\Entity(repositoryClass: TeamRepository::class)]
class Team {
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = NULL;

  #[ORM\Column(length: 255)]
  private ?string $name = NULL;

  #[ORM\Column(length: 255, nullable: TRUE)]
  private ?string $crest = NULL;

  #[ORM\Column(length: 255, nullable: TRUE)]
  private ?string $address = NULL;

  #[ORM\Column(length: 255, nullable: TRUE)]
  private ?string $website = NULL;

  #[ORM\Column(nullable: TRUE)]
  private ?int $founded = NULL;

  #[ORM\Column(length: 255, nullable: TRUE)]
  private ?string $colors = NULL;

  #[ORM\Column(length: 255, nullable: TRUE)]
  private ?string $venue = NULL;

  /**
   * The team squad.
   *
   * @var \Doctrine\Common\Collections\Collection<int, Player>
   */
  #[ORM\OneToMany(targetEntity: Player::class, mappedBy: 'team')]
  private Collection $squad;

  #[ORM\OneToOne(inversedBy: 'team', cascade: ['persist', 'remove'])]
  private ?Coach $coach = NULL;

  #[ORM\Column]
  private ?int $externalId = NULL;

  /**
   * Team constructor.
   */
  public function __construct() {
    $this->squad = new ArrayCollection();
  }

  /**
   * Get the team ID.
   *
   * @return int|null
   *   The team ID.
   */
  public function getId(): ?int {
    return $this->id;
  }

  /**
   * Get the team name.
   *
   * @return string|null
   *   The team name.
   */
  public function getName(): ?string {
    return $this->name;
  }

  /**
   * Set the team name.
   *
   * @param string $name
   *   The team name.
   */
  public function setName(string $name): static {
    $this->name = $name;

    return $this;
  }

  /**
   * Get the team crest.
   *
   * @return string|null
   *   The team crest.
   */
  public function getCrest(): ?string {
    return $this->crest;
  }

  /**
   * Set the team crest.
   *
   * @param string|null $crest
   *   The team crest.
   */
  public function setCrest(?string $crest): static {
    $this->crest = $crest;

    return $this;
  }

  /**
   * Get the team address.
   *
   * @return string|null
   *   The team address.
   */
  public function getAddress(): ?string {
    return $this->address;
  }

  /**
   * Set the team address.
   *
   * @param string|null $address
   *   The team address.
   */
  public function setAddress(?string $address): static {
    $this->address = $address;

    return $this;
  }

  /**
   * Get the team website.
   *
   * @return string|null
   *   The team website.
   */
  public function getWebsite(): ?string {
    return $this->website;
  }

  /**
   * Set the team website.
   *
   * @param string|null $website
   *   The team website.
   */
  public function setWebsite(?string $website): static {
    $this->website = $website;

    return $this;
  }

  /**
   * Get the team founded year.
   *
   * @return int|null
   *   The team founded year.
   */
  public function getFounded(): ?int {
    return $this->founded;
  }

  /**
   * Set the team founded year.
   *
   * @param int|null $founded
   *   The team founded year.
   */
  public function setFounded(?int $founded): static {
    $this->founded = $founded;

    return $this;
  }

  /**
   * Get the team colors.
   *
   * @return string|null
   *   The team colors.
   */
  public function getColors(): ?string {
    return $this->colors;
  }

  /**
   * Set the team colors.
   *
   * @param string|null $colors
   *   The team colors.
   */
  public function setColors(?string $colors): static {
    $this->colors = $colors;

    return $this;
  }

  /**
   * Get the team venue.
   *
   * @return string|null
   *   The team venue.
   */
  public function getVenue(): ?string {
    return $this->venue;
  }

  /**
   * Set the team venue.
   *
   * @param string|null $venue
   *   The team venue.
   */
  public function setVenue(?string $venue): static {
    $this->venue = $venue;

    return $this;
  }

  /**
   * Get the team squad.
   *
   * @return \Doctrine\Common\Collections\Collection<int,Player>
   *   The team squad.
   */
  public function getSquad(): Collection {
    return $this->squad;
  }

  /**
   * Add a player to the team squad.
   *
   * @param Player $squad
   *   The player to add.
   */
  public function addSquad(Player $squad): static {
    if (!$this->squad->contains($squad)) {
      $this->squad->add($squad);
      $squad->setTeam($this);
    }

    return $this;
  }

  /**
   * Remove a player from the team squad.
   *
   * @param Player $squad
   *   The player to remove.
   */
  public function removeSquad(Player $squad): static {
    if ($this->squad->removeElement($squad)) {
      // Set the owning side to null (unless already changed)
      if ($squad->getTeam() === $this) {
        $squad->setTeam(NULL);
      }
    }

    return $this;
  }

  /**
   * Get the team coach.
   *
   * @return Coach|null
   *   The team coach.
   */
  public function getCoach(): ?Coach {
    return $this->coach;
  }

  /**
   * Set the team coach.
   *
   * @param Coach|null $coach
   *   The team coach.
   */
  public function setCoach(?Coach $coach): static {
    $this->coach = $coach;

    return $this;
  }

  /**
   * Get the external ID of the team.
   *
   * @return int|null
   *   The external ID of the team.
   */
  public function getExternalId(): ?int {
    return $this->externalId;
  }

  /**
   * Set the external ID of the team.
   *
   * @param int $externalId
   *   The external ID of the team.
   */
  public function setExternalId(int $externalId): static {
    $this->externalId = $externalId;

    return $this;
  }

}
