<?php

namespace App\Entity;

use App\Repository\CoachRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Defines the properties of the Coach entity to represent the coaches.
 */
#[ORM\Entity(repositoryClass: CoachRepository::class)]
class Coach {
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = NULL;

  #[ORM\Column(length: 255)]
  private ?string $name = NULL;

  #[ORM\Column(length: 255, nullable: TRUE)]
  private ?string $dateOfBirth = NULL;

  #[ORM\Column(length: 255, nullable: TRUE)]
  private ?string $nationality = NULL;

  #[ORM\Column]
  private ?int $externalId = NULL;

  #[ORM\OneToOne(mappedBy: 'coach', cascade: ['persist', 'remove'])]
  private ?Team $team = NULL;

  /**
   * Get the coach ID.
   *
   * @return int|null
   *   The coach ID.
   */
  public function getId(): ?int {
    return $this->id;
  }

  /**
   * Get the coach name.
   *
   * @return string|null
   *   The coach name.
   */
  public function getName(): ?string {
    return $this->name;
  }

  /**
   * Set the coach name.
   *
   * @param string $name
   *   The coach name.
   */
  public function setName(string $name): static {
    $this->name = $name;

    return $this;
  }

  /**
   * Get the coach date of birth.
   *
   * @return string|null
   *   The coach date of birth.
   */
  public function getDateOfBirth(): ?string {
    return $this->dateOfBirth;
  }

  /**
   * Set the coach date of birth.
   *
   * @param string|null $dateOfBirth
   *   The coach date of birth.
   */
  public function setDateOfBirth(?string $dateOfBirth): static {
    $this->dateOfBirth = $dateOfBirth;

    return $this;
  }

  /**
   * Get the nationality.
   *
   * @return string|null
   *   The nationality.
   */
  public function getNationality(): ?string {
    return $this->nationality;
  }

  /**
   * Set the nationality.
   *
   * @param string|null $nationality
   *   The nationality.
   */
  public function setNationality(?string $nationality): static {
    $this->nationality = $nationality;

    return $this;
  }

  /**
   * Get the external ID.
   *
   * @return int|null
   *   The external ID.
   */
  public function getExternalId(): ?int {
    return $this->externalId;
  }

  /**
   * Set the external ID.
   *
   * @param int $externalId
   *   The external ID.
   */
  public function setExternalId(int $externalId): static {
    $this->externalId = $externalId;

    return $this;
  }

  /**
   * Get the team.
   *
   * @return Team|null
   *   The team.
   */
  public function getTeam(): ?Team {
    return $this->team;
  }

  /**
   * Set the team.
   *
   * @param Team|null $team
   *   The team.
   */
  public function setTeam(?Team $team): static {
    // Unset the owning side of the relation if necessary.
    if ($team === NULL && $this->team !== NULL) {
      $this->team->setCoach(NULL);
    }

    // Set the owning side of the relation if necessary.
    if ($team !== NULL && $team->getCoach() !== $this) {
      $team->setCoach($this);
    }

    $this->team = $team;

    return $this;
  }

}
