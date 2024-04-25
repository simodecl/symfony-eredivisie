<?php

namespace App\Entity;

use App\Repository\PlayerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Defines the properties of the Player entity to represent the players.
 */
#[ORM\Entity(repositoryClass: PlayerRepository::class)]
class Player {

  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = NULL;

  #[ORM\Column(length: 255)]
  private ?string $name = NULL;

  #[ORM\Column(length: 255, nullable: TRUE)]
  private ?string $position = NULL;

  #[ORM\Column(length: 255, nullable: TRUE)]
  private ?string $dateOfBirth = NULL;

  #[ORM\Column(length: 255, nullable: TRUE)]
  private ?string $nationality = NULL;

  #[ORM\Column]
  private ?int $externalId = NULL;

  #[ORM\ManyToOne(inversedBy: 'squad')]
  #[ORM\JoinColumn(nullable: FALSE)]
  private ?Team $team = NULL;

  /**
   * Get the player ID.
   *
   * @return int|null
   *   The player ID.
   */
  public function getId(): ?int {
    return $this->id;
  }

  /**
   * Get the player name.
   *
   * @return string|null
   *   The player name.
   */
  public function getName(): ?string {
    return $this->name;
  }

  /**
   * Set the player name.
   *
   * @param string $name
   *   The player name.
   */
  public function setName(string $name): static {
    $this->name = $name;

    return $this;
  }

  /**
   * Get the player position.
   *
   * @return string|null
   *   The player position.
   */
  public function getPosition(): ?string {
    return $this->position;
  }

  /**
   * Set the player position.
   *
   * @param string|null $position
   *   The player position.
   */
  public function setPosition(?string $position): static {
    $this->position = $position;

    return $this;
  }

  /**
   * Get the player date of birth.
   *
   * @return string|null
   *   The player date of birth.
   */
  public function getDateOfBirth(): ?string {
    return $this->dateOfBirth;
  }

  /**
   * Set the player date of birth.
   *
   * @param string|null $dateOfBirth
   *   The player date of birth.
   */
  public function setDateOfBirth(?string $dateOfBirth): static {
    $this->dateOfBirth = $dateOfBirth;

    return $this;
  }

  /**
   * Get the nationality of the player.
   *
   * @return string|null
   *   The nationality of the player.
   */
  public function getNationality(): ?string {
    return $this->nationality;
  }

  /**
   * Set the nationality of the player.
   *
   * @param string|null $nationality
   *   The nationality of the player.
   */
  public function setNationality(?string $nationality): static {
    $this->nationality = $nationality;

    return $this;
  }

  /**
   * Get the external ID of the player.
   *
   * @return int|null
   *   The external ID of the player.
   */
  public function getExternalId(): ?int {
    return $this->externalId;
  }

  /**
   * Set the external ID of the player.
   *
   * @param int $externalId
   *   The external ID of the player.
   */
  public function setExternalId(int $externalId): static {
    $this->externalId = $externalId;

    return $this;
  }

  /**
   * Get the team of the player.
   *
   * @return \App\Entity\Team|null
   *   The team of the player.
   */
  public function getTeam(): ?Team {
    return $this->team;
  }

  /**
   * Set the team of the player.
   *
   * @param \App\Entity\Team|null $team
   *   The team of the player.
   */
  public function setTeam(?Team $team): static {
    $this->team = $team;

    return $this;
  }

}
